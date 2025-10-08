<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\MessagesController;
use App\Models\MessageHistory; // Add this import

// Guest routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public routes
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms-of-service');
})->name('terms');

Route::get('/support', function () {
        return view('support');
    })->name('support');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        $totalApplicants = \App\Models\Applicant::count();
        $pending = \App\Models\Applicant::where('status', 'pending')->count();
        $reviewed = \App\Models\Applicant::where('status', 'reviewed')->count();
        $interviewed = \App\Models\Applicant::where('status', 'interviewed')->count();
        $approved = \App\Models\Applicant::where('status', 'approved')->count();
        $rejected = \App\Models\Applicant::where('status', 'rejected')->count();

        return view('dashboard', compact('totalApplicants', 'pending', 'reviewed', 'interviewed', 'approved', 'rejected'));
    });

    // Applicants
    Route::resource('applicants', ApplicantController::class)->only(['index', 'store', 'show', 'edit', 'update', 'destroy']);

    // Job Positions
    Route::post('job-positions', [PositionController::class, 'store'])->name('positions.store');
    Route::delete('job-positions/{position}', [PositionController::class, 'destroy'])->name('positions.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfile']);
    Route::post('/settings/app-credentials', [SettingsController::class, 'updateAppCredentials']);
    Route::post('/settings/password', [SettingsController::class, 'updatePassword']);
    
    // Admin-only routes for user management (handled in controller)
    Route::post('/settings/users', [SettingsController::class, 'storeUser']);
    Route::delete('/settings/users/{id}', [SettingsController::class, 'destroyUser']);
    Route::get('/settings/users/{id}/edit', [SettingsController::class, 'editUser'])->name('settings.users.edit');
    Route::put('/settings/users/{id}', [SettingsController::class, 'updateUser'])->name('settings.users.update');

    // Messages
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages');
    Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');

    // FIXED: Update /history route to fetch real data
    Route::get('/history', function () {
        $history = MessageHistory::with(['senderUser', 'applicant.position', 'template'])
            ->latest('sent_at')
            ->get();

        $messages = $history->map(function ($msg) {
            return (object) [
                'id' => $msg->id,
                'sender' => $msg->senderUser?->email ?? 'Unknown Sender',
                'recipients' => [
                    (object) [
                        'name' => $msg->applicant?->full_name ?? 'Unknown',
                        'email' => $msg->recipient_email
                    ]
                ],
                'subject' => $msg->subject,
                'body' => $msg->body,
                'status' => $msg->send_status, // Use send_status from DB
                'sent_at' => $msg->sent_at?->format('Y-m-d H:i:s') ?? 'Unknown',
                'job_position' => $msg->applicant?->position?->title ?? 'N/A'
            ];
        });

        return view('history', compact('messages'));
    })->name('history');
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Protected 404 fallback (only triggers for authenticated users on unmatched protected routes)
Route::fallback(function () {
    return view('404');
})->middleware('auth');