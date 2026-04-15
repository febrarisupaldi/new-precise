<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Logistic\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module logistic di bawah ini
