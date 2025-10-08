<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // 🔹 Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🔹 Show register form (with check for existing users)
    public function showRegister()
    {
        if (User::count() > 0) {
            // Block registration if users exist; redirect to login with message
            return redirect('/login')->with('registration_blocked', 'Admin already exists. Cannot register. Please login to admin account and create new HR user.');
        }

        return view('auth.register');
    }

    // 🟢 REGISTER USER
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'term_accept' => 'accepted', // Ensures checkbox is checked; prevents unchecked submission
        ]);

        // Double-check: Only allow if no users exist (extra safety)
        if (User::count() > 0) {
            return back()->withErrors(['email' => 'Registration is not available. Please contact admin.']);
        }

        $role = User::count() === 0 ? 'admin' : 'hr';

        $user = User::create([
            'id' => (string) Str::uuid(),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'role' => $role,
            'accepted_terms_and_privacy' => true, // Set to true since validation passed
        ]);

        // Create associated SMTP credential with Gmail defaults
        $user->smtpCredential()->create([
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 587,
            'smtp_secure' => true,
            'smtp_email' => $user->email,
            'smtp_app_password_encrypted' => null, // Will be set later in settings
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Welcome to HR Connect!');
    }

    // 🟡 LOGIN USER
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password_hash)) {
            return back()->with('error', 'Invalid email or password.');
        }

        Auth::login($user);

        return redirect('/')->with('success', 'Login successful!');
    }

    // 🔴 LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}