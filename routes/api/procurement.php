<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Procurement\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module procurement di bawah ini
