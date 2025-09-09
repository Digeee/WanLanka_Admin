<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController;


Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{id}', [PackageController::class, 'show']);
