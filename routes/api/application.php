<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Application\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module application di bawah ini
