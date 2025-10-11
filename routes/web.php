<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserSentPlaceController;
use App\Http\Controllers\Admin\GuiderController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\AccommodationController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UIManagementController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FixedPackageBookingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'adminLogin']);

Route::get('admin/forgot-password', [AuthController::class, 'showAdminForgotPasswordForm'])
    ->name('admin.forgot-password');
Route::post('admin/forgot-password', [AuthController::class, 'adminSendOtp']);

Route::get('admin/verify-otp', [AuthController::class, 'showOtpVerificationForm'])
    ->name('admin.verify-otp');
Route::post('admin/verify-otp', [AuthController::class, 'verifyOtp']);

Route::get('admin/reset-password-form', [AuthController::class, 'showAdminResetPasswordForm'])
    ->name('admin.reset-password-form');
Route::post('admin/reset-password', [AuthController::class, 'adminResetPassword']);

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/

// Protect dashboard & resources with middleware
Route::middleware(['auth:admin'])->group(function () {
    // Redirect root to dashboard when logged in
    Route::get('/admin', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // All admin routes that require authentication
    Route::prefix('admin')->name('admin.')->group(function () {
        // User-Sent Places (custom CRUD)
        Route::prefix('places/user-sent')->name('places.user-sent.')->group(function () {
            Route::get('/', [UserSentPlaceController::class, 'index'])->name('index');
            Route::get('/{id}', [UserSentPlaceController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [UserSentPlaceController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserSentPlaceController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserSentPlaceController::class, 'destroy'])->name('destroy');
        });

        // Resource Controllers
        Route::resource('guiders', GuiderController::class);
        Route::resource('vehicles', VehicleController::class);
        Route::resource('accommodations', AccommodationController::class);
        Route::resource('places', PlaceController::class);
        Route::resource('sliders', SliderController::class);
        Route::resource('packages', PackageController::class);
        Route::resource('users', UserController::class);

        // UI Management
        Route::get('ui_management', [UIManagementController::class, 'index'])->name('ui_management.UI_index');

        // Bookings
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [AdminBookingController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [AdminBookingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminBookingController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminBookingController::class, 'destroy'])->name('destroy');
        });

        // Fixed Package Bookings
        Route::prefix('fixedpackage/bookings')->name('fixedpackage.bookings.')->group(function () {
            Route::get('/', [FixedPackageBookingController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [FixedPackageBookingController::class, 'edit'])->name('edit');
            Route::put('/{id}', [FixedPackageBookingController::class, 'update'])->name('update');
            Route::delete('/{id}', [FixedPackageBookingController::class, 'destroy'])->name('destroy');
        });
    });
});