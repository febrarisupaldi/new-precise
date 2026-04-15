<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Engineering\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module engineering di bawah ini
