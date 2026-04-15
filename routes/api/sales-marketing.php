<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalesMarketing\IndexController;

Route::get('/', [IndexController::class, 'index']);
// Tambahkan route module sales-marketing di bawah ini
