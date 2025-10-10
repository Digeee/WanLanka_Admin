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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| Admin Routes (Development Mode)
|--------------------------------------------------------------------------
*/

// ✅ Root goes directly to dashboard (no login)
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// ✅ Group all admin routes
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | User-Sent Places (custom CRUD)
    |--------------------------------------------------------------------------
    */
Route::prefix('places/user-sent')->name('places.user-sent.')->group(function () {
    Route::get('/', [UserSentPlaceController::class, 'index'])->name('index');     // list
    Route::get('/{id}', [UserSentPlaceController::class, 'show'])->name('show');   // 👈 ADD THIS (View details)
    Route::get('/{id}/edit', [UserSentPlaceController::class, 'edit'])->name('edit'); // edit form
    Route::put('/{id}', [UserSentPlaceController::class, 'update'])->name('update'); // update action
    Route::delete('/{id}', [UserSentPlaceController::class, 'destroy'])->name('destroy'); // delete action
});


    /*
    |--------------------------------------------------------------------------
    | Resource Controllers
    |--------------------------------------------------------------------------
    */
    Route::resource('guiders', GuiderController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('accommodations', AccommodationController::class);
    Route::resource('places', PlaceController::class); // normal admin places
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
});










/*
|--------------------------------------------------------------------------
| 🔐 Auth Routes (Enable in production)
|--------------------------------------------------------------------------
| Uncomment when you are ready to use admin login.
|--------------------------------------------------------------------------
|
| Route::get('/', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
| Route::post('admin/login', [AuthController::class, 'adminLogin']);
|
| Route::get('admin/forgot-password', [AuthController::class, 'showAdminForgotPasswordForm'])
|     ->name('admin.forgot-password');
| Route::post('admin/forgot-password', [AuthController::class, 'adminSendOtp']);
|
| Route::get('admin/verify-otp', [AuthController::class, 'showOtpVerificationForm'])
|     ->name('admin.verify-otp');
| Route::post('admin/verify-otp', [AuthController::class, 'verifyOtp']);
|
| Route::get('admin/reset-password-form', [AuthController::class, 'showAdminResetPasswordForm'])
|     ->name('admin.reset-password-form');
| Route::post('admin/reset-password', [AuthController::class, 'adminResetPassword']);
|
| // Protect dashboard & resources with middleware
| Route::middleware('auth:admin')->group(function () {
|     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
|     // user-sent places etc.
| });
|
*/
