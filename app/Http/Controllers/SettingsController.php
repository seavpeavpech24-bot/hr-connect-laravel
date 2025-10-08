<?php
// app/Http/Controllers/SettingsController.php - Updated with manual admin checks (replaces $this->authorize('admin')), JSON errors for AJAX, and SMTP creation on new user (consistent with registration)

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SmtpCredential;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Crypt;

class SettingsController extends Controller
{
    public function index()
    {
        $users = Auth::user()->role === 'admin' ? User::all() : collect();
        return view('settings', compact('users'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',  // Changed to nullable; set to 'required' if mandatory
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $user->full_name = $request->full_name;
        $user->company_name = $request->company_name;  // Added this line

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return response()->json(['success' => true]);
    }

    public function updateAppCredentials(Request $request)
    {
        $request->validate([
            'smtp_email' => 'required|email',
            'smtp_app_password' => 'nullable|string|min:16|max:16',
        ]);

        $user = Auth::user();
        $existing = $user->smtpCredential;

        $attributes = [
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_secure' => true,
            'smtp_email' => $request->smtp_email,
        ];

        // Use encryption (reversible) instead of hashing
        $passwordValue = $request->filled('smtp_app_password') 
            ? Crypt::encrypt($request->smtp_app_password) 
            : ($existing ? $existing->smtp_app_password_encrypted : null);

        $attributes['smtp_app_password_encrypted'] = $passwordValue;

        $credential = $user->smtpCredential()->updateOrCreate(
            ['user_id' => $user->id],
            $attributes
        );

        \Log::info('SMTP Updated', [
            'user_id' => $user->id,
            'email' => $request->smtp_email,
            'has_password' => !is_null($passwordValue),
            'saved_id' => $credential->id
        ]);

        return response()->json(['success' => true]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password_hash)) {
            return response()->json(['error' => 'Current password is incorrect.'], 422);
        }

        $user->password_hash = Hash::make($request->new_password);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function storeUser(Request $request)
    {
        // Manual admin check
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255', //add company field to hr
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $role = User::count() === 0 ? 'admin' : 'hr'; // First user ever is admin; all others 'hr'

        $user = User::create([
            'id' => (string) Str::uuid(),
            'full_name' => $request->full_name,
            'company_name' => Auth::user()->company_name,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role' => $role,
        ]);

        // Create associated SMTP credential with Gmail defaults
        $user->smtpCredential()->create([
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_secure' => true,
            'smtp_email' => $user->email,
            'smtp_app_password_encrypted' => null,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroyUser($id)
    {
        // Manual admin check
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $user = User::findOrFail($id);
        if ($user->id !== auth()->id()) {
            $user->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Cannot delete yourself.'], 422);
    }

    public function editUser($id)
    {
        // Manual admin check
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }
        $user = User::findOrFail($id);
        return view('settings.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        // Manual admin check
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized.');
        }

        $user = User::findOrFail($id);
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => ['required', Rule::in(['admin', 'hr'])],
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password_hash = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('settings.index')->with('success', 'User updated.');
    }
}