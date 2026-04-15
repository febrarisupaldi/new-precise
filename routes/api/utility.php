<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Utility\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module utility di bawah ini
