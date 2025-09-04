<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GuiderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\AccommodationController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\UIManagementController;
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







Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('guiders', GuiderController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('vehicles', VehicleController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('accommodations', AccommodationController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {

    Route::resource('places', PlaceController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('sliders', SliderController::class);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('ui_management', [UIManagementController::class, 'index'])->name('ui_management.UI_index');
});
