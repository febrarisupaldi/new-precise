<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalesMarketing\IndexController;

Route::get('/', [IndexController::class, 'index']);
Route::prefix("sales-order")->group(function(){
    Route::get('/', [App\Http\Controllers\Api\SalesMarketing\SalesOrderController::class, 'index']);
});
// Tambahkan route module sales-marketing di bawah ini
