<?php

use Illuminate\Support\Facades\Route;

Route::prefix("sales-order")->group(function(){
    Route::get('/', [App\Http\Controllers\Api\SalesMarketing\SalesOrderController::class, 'index']);
    Route::get('/{id}', [App\Http\Controllers\Api\SalesMarketing\SalesOrderController::class, 'show']);
});
// Tambahkan route module sales-marketing di bawah ini
