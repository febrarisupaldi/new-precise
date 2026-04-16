<?php

use Illuminate\Support\Facades\Route;

// Country
Route::prefix('countries')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CountryController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CountryController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CountryController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'update']);
});

// State
Route::prefix('states')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\StateController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\StateController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\StateController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'update']);
});
