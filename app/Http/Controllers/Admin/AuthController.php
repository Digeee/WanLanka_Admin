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

    // Retrieve the admin by email
    $admin = Admin::where('email', $request->email)->first();

    // Check if the admin exists and if the plain text passwords match
    if ($admin && $admin->password === $request->password) {  // Plaintext comparison
        Auth::login($admin);

        return redirect()->route('admin.dashboard');  // Redirect to dashboard after successful login
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

        // Generate a 6-digit numeric OTP
        $otp_token = rand(100000, 999999);  // Generates a random 6-digit number

        // Store OTP in the session for comparison later
        session(['otp_token' => $otp_token]);

        // Send OTP to admin email directly without storing it in the database
        Mail::to($request->email)->send(new OtpVerificationMail($otp_token));

        return redirect()->route('admin.verify-otp', ['email' => $request->email, 'otp_token' => $otp_token])
                         ->with('status', 'OTP sent to your email');
    }

    // Show OTP Verification Form for Admins
    public function showOtpVerificationForm(Request $request) {
        return view('admin.auth.verify-otp', [
            'email' => $request->email,
            'otp_token' => $request->otp_token
        ]);
    }

    // Verify OTP and Show Reset Password Form
    public function verifyOtp(Request $request) {
        $request->validate([
            'otp_token' => 'required|string',
        ]);

        // Retrieve OTP from session
        $sessionOtp = session('otp_token');

        // Compare OTP entered by the user with the OTP stored in the session
        if ($request->otp_token == $sessionOtp) {
            // If OTP is correct, redirect to the password reset form with the email and OTP
            return redirect()->route('admin.reset-password-form', [
                'email' => $request->email,
                'otp_token' => $request->otp_token
            ]);
        }

        // If OTP is invalid, reload the page with error
        return back()->withErrors(['otp_token' => 'Invalid OTP']);
    }

    // Show Reset Password Form for Admins
    public function showAdminResetPasswordForm(Request $request) {
        return view('admin.auth.reset-password', [
            'email' => $request->email,
            'otp_token' => $request->otp_token
        ]);
    }

    // Reset Password for Admin
    public function adminResetPassword(Request $request) {
    // Validate the incoming data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|confirmed|min:8',
        'otp_token' => 'required|string',
    ]);

    // Retrieve admin by email
    $admin = Admin::where('email', $request->email)->first();

    // Check if the admin exists
    if (!$admin) {
        return back()->withErrors(['email' => 'User not found']);
    }

    // Check if OTP is still valid (it should have been validated earlier)
    $sessionOtp = session('otp_token');

    if ($sessionOtp) {
        // Store the password as plain text (no hashing)
        $admin->password = $request->password; // Directly store the password
        $admin->save();

        // Clear OTP from session after successful reset
        session()->forget('otp_token');

        // Redirect to login page with success message
        return redirect()->route('admin.login')->with('status', 'Password reset successful. You can now log in.');
    }

    // If OTP is missing or invalid
    return back()->withErrors(['otp_token' => 'Invalid or expired OTP']);
}

}
