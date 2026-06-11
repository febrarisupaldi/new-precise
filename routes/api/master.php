<?php

use Illuminate\Support\Facades\Route;

// Address Type
Route::prefix('address-types')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\AddressTypeController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\AddressTypeController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\AddressTypeController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\AddressTypeController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\AddressTypeController::class, 'update']);
});

Route::prefix('cities')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CityController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CityController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CityController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CityController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CityController::class, 'update']);
});

Route::prefix('color-types')->group(function(){
    Route::get('/',[App\Http\Controllers\Api\Master\ColorTypeController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\ColorTypeController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\ColorTypeController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\ColorTypeController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\ColorTypeController::class, 'update']);
    Route::delete('{id}', [App\Http\Controllers\Api\Master\ColorTypeController::class, 'delete']);
});

// Company Type
Route::prefix('company-types')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CompanyTypeController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CompanyTypeController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CompanyTypeController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CompanyTypeController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CompanyTypeController::class, 'update']);
});

// Country
Route::prefix('countries')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CountryController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CountryController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CountryController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CountryController::class, 'update']);
});

Route::prefix('customers')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CustomerController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\CustomerController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CustomerController::class, 'show']);
    Route::get('{customerIDs}/addresses', [App\Http\Controllers\Api\Master\CustomerController::class, 'findWithAddresses']);
    Route::post('/', [App\Http\Controllers\Api\Master\CustomerController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CustomerController::class, 'update']);
});

Route::prefix('customer-addresses')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\CustomerAddressController::class, 'index']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\CustomerAddressController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\CustomerAddressController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\CustomerAddressController::class, 'update']);
    Route::delete('{id}', [App\Http\Controllers\Api\Master\CustomerAddressController::class, 'delete']);
});

Route::prefix('packagings')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\PackagingController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\PackagingController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\PackagingController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\PackagingController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\PackagingController::class, 'update']);
});

Route::prefix('product-equivalents')->group(function(){
    Route::get('/', [App\Http\Controllers\Api\Master\ProductEquivalentController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\ProductEquivalentController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\ProductEquivalentController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\ProductEquivalentController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\ProductEquivalentController::class, 'update']);
});

// State
Route::prefix('states')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\StateController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\StateController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\StateController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\StateController::class, 'update']);
});

// Steel Type
Route::prefix('steel-types')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\SteelTypeController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\SteelTypeController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\SteelTypeController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\SteelTypeController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\SteelTypeController::class, 'update']);
});

Route::prefix('vehicles')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\VehicleController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\VehicleController::class, 'check']);
    Route::get('license-number/{licenseNumber}', [App\Http\Controllers\Api\Master\VehicleController::class, 'findByLicenseNumber']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\VehicleController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\VehicleController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\VehicleController::class, 'update']);
});

Route::prefix('warehouses')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\WarehouseController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\WarehouseController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\WarehouseController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\WarehouseController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\WarehouseController::class, 'update']);
    Route::delete('{id}', [App\Http\Controllers\Api\Master\WarehouseController::class, 'delete']);
});

Route::prefix('workcenters')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'index']);
    Route::get('check', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'check']);
    Route::get('{id}', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'show']);
    Route::post('/', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'store']);
    Route::put('{id}', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'update']);
    Route::delete('{id}', [App\Http\Controllers\Api\Master\WorkcenterController::class, 'delete']);
});