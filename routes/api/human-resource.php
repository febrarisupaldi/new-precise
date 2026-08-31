<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HumanResource\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module humanresource di bawah ini
