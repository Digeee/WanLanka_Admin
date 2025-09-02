<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\GuiderController;

// Admin Routes
Route::get('/', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');  // Route for showing the login form
Route::post('admin/login', [AuthController::class, 'adminLogin']);  // Route for handling login form submission (POST)

Route::get('admin/forgot-password', [AuthController::class, 'showAdminForgotPasswordForm'])->name('admin.forgot-password');
Route::post('admin/forgot-password', [AuthController::class, 'adminSendOtp']);

Route::get('admin/verify-otp', [AuthController::class, 'showOtpVerificationForm'])->name('admin.verify-otp');
Route::post('admin/verify-otp', [AuthController::class, 'verifyOtp']);

// Define only one route for reset password form
Route::get('admin/reset-password-form', [AuthController::class, 'showAdminResetPasswordForm'])->name('admin.reset-password-form');
Route::post('admin/reset-password', [AuthController::class, 'adminResetPassword']);


Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');




Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('guiders', GuiderController::class);
});
