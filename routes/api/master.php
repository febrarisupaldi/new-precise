<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cities')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CityController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CityController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CityController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CityController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CityController::class, 'update']);
});

// Country
Route::prefix('countries')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CountryController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CountryController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CountryController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'update']);
});

Route::prefix('packagings')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\PackagingController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\PackagingController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\PackagingController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\PackagingController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\PackagingController::class, 'update']);
});

// State
Route::prefix('states')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\StateController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\StateController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\StateController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'update']);
});

Route::prefix('vehicles')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\VehicleController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\VehicleController::class, 'check']);
    Route::get('license-number/{licenseNumber}', [App\Http\Controllers\Api\Master\VehicleController::class, 'findByLicenseNumber']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\VehicleController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\VehicleController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\VehicleController::class, 'update']);
});
