<?php

use Illuminate\Support\Facades\Route;


// Load Modular Routes (Accounting, Production, etc.)
foreach (glob(__DIR__ . '/api/*.php') as $file) {
    $prefix = basename($file, '.php');

    $route = Route::prefix($prefix);

    // Auth routes should not be protected by auth:api
    if ($prefix !== 'auth') {
        $route->middleware('auth:api');
    }

    $route->group($file);
}

Route::fallback(function () {
    return response()->json([
        'message' => 'Resource not found.',
    ], 404);
});
