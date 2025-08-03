<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;
use App\Mail\OtpVerificationMail;

class AuthController extends Controller
{
    // Show Admin Login Form
    public function showAdminLoginForm() {
        return view('admin.auth.login');
    }

    // Handle Admin Login
    public function adminLogin(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $admin->password === $request->password) {
            Auth::login($admin);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Wrong credentials']);
    }

    // Show Forgot Password Form for Admins
    public function showAdminForgotPasswordForm() {
        return view('admin.auth.forgot-password');
    }

    // Handle Forgot Password for Admins (Send OTP)
    public function adminSendOtp(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $otp_token = rand(100000, 999999);

        // Store email & OTP in session
        session([
            'otp_email' => $request->email,
            'otp_token' => $otp_token
        ]);

        Mail::to($request->email)->send(new OtpVerificationMail($otp_token));

        return redirect()->route('admin.verify-otp')->with('status', 'OTP sent to your email.');
    }

    // Show OTP Verification Form
    public function showOtpVerificationForm() {
        if (!session()->has('otp_email') || !session()->has('otp_token')) {
            return redirect()->route('admin.forgot-password')->withErrors(['session' => 'Session expired. Please try again.']);
        }

        return view('admin.auth.verify-otp');
    }

    // Verify OTP
    public function verifyOtp(Request $request) {
        $request->validate([
            'otp_token' => 'required|string',
        ]);

        $sessionOtp = session('otp_token');

        if ($request->otp_token == $sessionOtp) {
            // Redirect to reset-password form
            return redirect()->route('admin.reset-password-form');
        }

        return back()->withErrors(['otp_token' => 'Invalid OTP']);
    }

    // Show Reset Password Form
    public function showAdminResetPasswordForm() {
        if (!session()->has('otp_email')) {
            return redirect()->route('admin.forgot-password')->withErrors(['session' => 'Session expired.']);
        }

        return view('admin.auth.reset-password');
    }

    // Handle Password Reset
    public function adminResetPassword(Request $request) {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $email = session('otp_email');
        $sessionOtp = session('otp_token');

        if (!$email || !$sessionOtp) {
            return redirect()->route('admin.forgot-password')->withErrors(['session' => 'Session expired or invalid.']);
        }

        $admin = Admin::where('email', $email)->first();

        if (!$admin) {
            return back()->withErrors(['email' => 'User not found']);
        }

        $admin->password = $request->password; // Plaintext for now
        $admin->save();

        // Clear session values
        session()->forget(['otp_email', 'otp_token']);

        return redirect()->route('admin.login')->with('status', 'Password reset successful. Please log in.');
    }
}
