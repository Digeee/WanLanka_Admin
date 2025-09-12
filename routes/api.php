<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PlaceController;


Route::get('/packages', [PackageController::class, 'index']);
Route::get('/packages/{id}', [PackageController::class, 'show']);





    Route::get('/provinces', [PlaceController::class, 'provinces']);
    Route::get('/provinces/{slug}/places', [PlaceController::class, 'provincePlaces']);
    Route::get('/places/{slug}', [PlaceController::class, 'show']);
