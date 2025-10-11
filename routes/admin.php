<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\GuiderController;
use App\Http\Controllers\Admin\FixedPackageBookingController;

Route::resource('admin/guiders', GuiderController::class);

// Fixed Package Bookings
Route::prefix('fixedpackage/bookings')->name('fixedpackage.bookings.')->group(function () {
    Route::get('/', [FixedPackageBookingController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [FixedPackageBookingController::class, 'edit'])->name('edit');
    Route::put('/{id}', [FixedPackageBookingController::class, 'update'])->name('update');
    Route::delete('/{id}', [FixedPackageBookingController::class, 'destroy'])->name('destroy');
});


