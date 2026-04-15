<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('me', [AuthController::class, 'me'])->middleware('auth:api');
});

// Load Modular Routes (Accounting, Production, etc.)
foreach (glob(__DIR__ . '/api/*.php') as $file) {
    $prefix = basename($file, '.php');
    Route::prefix($prefix)
        ->middleware('auth:api')
        ->group($file);
}
