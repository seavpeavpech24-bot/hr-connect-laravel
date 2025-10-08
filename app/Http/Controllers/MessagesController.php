<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\MessageHistory;
use Exception;

class MessagesController extends Controller
{
    public function index()
    {
        $applicants = Applicant::with('position')->get()->map(function ($applicant) {
            return (object) [
                'id' => $applicant->id,
                'fullName' => $applicant->full_name,
                'email' => $applicant->email,
                'jobTitle' => $applicant->position?->title ?? 'N/A',
                'status' => $applicant->status_label,
            ];
        });

        $loggedInCompany = auth()->user()->company_name ?? 'Your Company';

        return view('messages', compact('applicants', 'loggedInCompany'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'applicant_ids' => 'required|array|min:1',
            'applicant_ids.*' => 'exists:applicants,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|in:approval,rejection,interview',
            'interview_date' => 'nullable|date',  // Only for interview
            'interview_time' => 'nullable|string',  // HH:MM
            'interview_location' => 'nullable|string|max:500',  // Only for interview
        ]);

        $user = auth()->user();
        $credential = $user->smtpCredential;

        if (!$credential) {
            return response()->json(['error' => 'No SMTP credentials configured. Update in Settings > App Credentials.'], 400);
        }

        if (!$credential->smtp_app_password_encrypted) {
            return response()->json(['error' => 'SMTP app password not set. Update in Settings > App Credentials.'], 400);
        }

        try {
            $decryptedPassword = Crypt::decrypt($credential->smtp_app_password_encrypted);

            // Dynamically configure mail for this user
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.transport', 'smtp');
            Config::set('mail.mailers.smtp.host', $credential->smtp_host);
            Config::set('mail.mailers.smtp.port', $credential->smtp_port);
            Config::set('mail.mailers.smtp.encryption', $credential->smtp_secure ? 'tls' : null);
            Config::set('mail.mailers.smtp.username', $credential->smtp_email);
            Config::set('mail.mailers.smtp.password', $decryptedPassword);
            Config::set('mail.from.address', $credential->smtp_email);
            Config::set('mail.from.name', $user->full_name);

            $companyName = $user->company_name ?? 'Your Company';
            $interviewDate = $request->interview_date;
            $interviewTime = $request->interview_time ? date('h:i A', strtotime($request->interview_time)) : null;  // Format to 12h AM/PM
            $interviewLocation = $request->interview_location;

            $sentCount = 0;
            $failedCount = 0;

            foreach ($request->applicant_ids as $applicantId) {
                $applicant = Applicant::with('position')->findOrFail($applicantId);

                // FIXED: Robust replacement - ensure all placeholders are handled, even if null
                $personalizedSubject = str_replace('@{{jobTitle}}', $applicant->position?->title ?? 'the position', $request->subject);

                $personalizedBody = $request->body;
                $personalizedBody = str_replace('@{{name}}', $applicant->full_name, $personalizedBody);
                $personalizedBody = str_replace('@{{jobTitle}}', $applicant->position?->title ?? 'the position', $personalizedBody);
                $personalizedBody = str_replace('@{{companyName}}', $companyName, $personalizedBody);  // FIXED: Explicit step-by-step replaces for reliability

                // Add interview placeholders if type=interview
                if ($request->type === 'interview') {
                    $personalizedBody = str_replace('@{{interviewDate}}', $interviewDate ?? '[Date]', $personalizedBody);
                    $personalizedBody = str_replace('@{{interviewTime}}', $interviewTime ?? '[Time]', $personalizedBody);
                    $personalizedBody = str_replace('@{{interviewLocation}}', $interviewLocation ?? '[Location]', $personalizedBody);
                }

                // Log for debug (remove in prod)
                \Log::info('Personalized Email Debug', [
                    'applicant_id' => $applicant->id,
                    'subject' => $personalizedSubject,
                    'body_preview' => substr($personalizedBody, 0, 200),  // First 200 chars
                    'company_name' => $companyName
                ]);

                $sendStatus = 'sent';
                $smtpResponse = null;

                try {
                    Mail::raw($personalizedBody, function ($message) use ($personalizedSubject, $applicant) {
                        $message->to($applicant->email)->subject($personalizedSubject);
                    });
                } catch (Exception $e) {
                    $sendStatus = 'failed';
                    $smtpResponse = $e->getMessage();
                    $failedCount++;
                }

                // Log to history (now with $timestamps=false, no auto created_at/updated_at)
                MessageHistory::create([
                    'sender_user_id' => $user->id,
                    'applicant_id' => $applicant->id,
                    'template_id' => null,  // Hardcoded for now; link to MessageTemplate later
                    'recipient_email' => $applicant->email,
                    'subject' => $personalizedSubject,
                    'body' => $personalizedBody,
                    'send_status' => $sendStatus,
                    'smtp_response' => $smtpResponse,
                    'attachments_json' => null,
                ]);

                // Update applicant status if sent successfully
                if ($sendStatus === 'sent') {
                    $newStatus = match ($request->type) {
                        'interview' => 'interviewed',
                        'rejection' => 'rejected',
                        'approval' => 'approved',
                        default => $applicant->status,
                    };
                    $applicant->update(['status' => $newStatus]);
                    $sentCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Sent to {$sentCount} applicants ({$failedCount} failed). Check Message History for details."
            ]);

        } catch (Exception $e) {
            \Log::error('Messages Store Error', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to send: ' . $e->getMessage()], 500);
        }
    }
}