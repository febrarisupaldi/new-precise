<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PPIC\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module ppic di bawah ini
