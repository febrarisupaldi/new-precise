<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Accounting\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module accounting di bawah ini
