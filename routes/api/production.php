<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Production\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module production di bawah ini
