<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => response()->json([
    'message' => 'Resource not found.',
], 404));
