<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OEM\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module oem di bawah ini
