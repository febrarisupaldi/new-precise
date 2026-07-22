<?php

use App\Http\Controllers\Api\Master\{
    AddressTypeController,
    CityController,
    ColorTypeController,
    CompanyTypeController,
    CountryController,
    CustomerAddressController,
    CustomerController,
    MachineInjectionController,
    MachinePressingController,
    MachineStatusController,
    MoldPressingController,
    MoldStatusController,
    PackagingController,
    ProductEquivalentController,
    StateController,
    SteelTypeController,
    UOMController,
    ProductBrandController,
    VehicleController,
    WarehouseController,
    WorkcenterController,
};
use Illuminate\Support\Facades\Route;

// Address Type
Route::prefix('address-types')->group(function () {
    Route::get('/', [AddressTypeController::class, 'index']);
    Route::get('check', [AddressTypeController::class, 'check']);
    Route::get('{id}', [AddressTypeController::class, 'show']);
    Route::post('/', [AddressTypeController::class, 'store']);
    Route::put('{id}', [AddressTypeController::class, 'update']);
});

Route::prefix('cities')->group(function () {
    Route::get('/', [CityController::class, 'index']);
    Route::get('check', [CityController::class, 'check']);
    Route::get('{id}', [CityController::class, 'show']);
    Route::post('/', [CityController::class, 'store']);
    Route::put('{id}', [CityController::class, 'update']);
});

Route::prefix('color-types')->group(function () {
    Route::get('/', [ColorTypeController::class, 'index']);
    Route::get('check', [ColorTypeController::class, 'check']);
    Route::get('{id}', [ColorTypeController::class, 'show']);
    Route::post('/', [ColorTypeController::class, 'store']);
    Route::put('{id}', [ColorTypeController::class, 'update']);
    Route::delete('{id}', [ColorTypeController::class, 'delete']);
});

// Company Type
Route::prefix('company-types')->group(function () {
    Route::get('/', [CompanyTypeController::class, 'index']);
    Route::get('check', [CompanyTypeController::class, 'check']);
    Route::get('{id}', [CompanyTypeController::class, 'show']);
    Route::post('/', [CompanyTypeController::class, 'store']);
    Route::put('{id}', [CompanyTypeController::class, 'update']);
});

// Country
Route::prefix('countries')->group(function () {
    Route::get('/', [CountryController::class, 'index']);
    Route::get('check', [CountryController::class, 'check']);
    Route::get('{id}', [CountryController::class, 'show']);
    Route::post('/', [CountryController::class, 'store']);
    Route::put('{id}', [CountryController::class, 'update']);
});

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index']);
    Route::get('check', [CustomerController::class, 'check']);
    Route::get('{id}', [CustomerController::class, 'show']);
    Route::get('{customerIDs}/addresses', [CustomerController::class, 'findWithAddresses']);
    Route::post('/', [CustomerController::class, 'store']);
    Route::put('{id}', [CustomerController::class, 'update']);
});

Route::prefix('customer-addresses')->group(function () {
    Route::get('/', [CustomerAddressController::class, 'index']);
    Route::get('{id}', [CustomerAddressController::class, 'show']);
    Route::post('/', [CustomerAddressController::class, 'store']);
    Route::put('{id}', [CustomerAddressController::class, 'update']);
    Route::delete('{id}', [CustomerAddressController::class, 'delete']);
});

Route::prefix('machine-injections')->group(function () {
    Route::get('/', [MachineInjectionController::class, 'index']);
    Route::get('check', [MachineInjectionController::class, 'check']);
    Route::get('{id}', [MachineInjectionController::class, 'show']);
    Route::post('/', [MachineInjectionController::class, 'store']);
    Route::put('{id}', [MachineInjectionController::class, 'update']);
});

Route::prefix('machine-pressings')->group(function () {
    Route::get('/', [MachinePressingController::class, 'index']);
    Route::get('check', [MachinePressingController::class, 'check']);
    Route::get('{id}', [MachinePressingController::class, 'show']);
    Route::post('/', [MachinePressingController::class, 'store']);
    Route::put('{id}', [MachinePressingController::class, 'update']);
});

Route::prefix('machine-statuses')->group(function () {
    Route::get('/', [MachineStatusController::class, 'index']);
    Route::get('check', [MachineStatusController::class, 'check']);
    Route::get('{id}', [MachineStatusController::class, 'show']);
    Route::post('/', [MachineStatusController::class, 'store']);
    Route::put('{id}', [MachineStatusController::class, 'update']);
});

Route::prefix('mold-pressings')->group(function () {
    Route::get('/', [MoldPressingController::class, 'index']);
    Route::get('check', [MoldPressingController::class, 'check']);
    Route::get('{id}', [MoldPressingController::class, 'show']);
    Route::post('/', [MoldPressingController::class, 'store']);
    Route::put('{id}', [MoldPressingController::class, 'update']);
});

Route::prefix('mold-statuses')->group(function () {
    Route::get('/', [MoldStatusController::class, 'index']);
    Route::get('{id}', [MoldStatusController::class, 'show']);
    Route::post('/', [MoldStatusController::class, 'store']);
    Route::put('{id}', [MoldStatusController::class, 'update']);
});

Route::prefix('packagings')->group(function () {
    Route::get('/', [PackagingController::class, 'index']);
    Route::get('check', [PackagingController::class, 'check']);
    Route::get('{id}', [PackagingController::class, 'show']);
    Route::post('/', [PackagingController::class, 'store']);
    Route::put('{id}', [PackagingController::class, 'update']);
});

Route::prefix('product-brands')->group(function () {
    Route::get('/', [ProductBrandController::class, 'index']);
    Route::get('check', [ProductBrandController::class, 'check']);
    Route::get('{id}', [ProductBrandController::class, 'show']);
    Route::post('/', [ProductBrandController::class, 'store']);
    Route::put('{id}', [ProductBrandController::class, 'update']);
});

Route::prefix('product-equivalents')->group(function () {
    Route::get('/', [ProductEquivalentController::class, 'index']);
    Route::get('check', [ProductEquivalentController::class, 'check']);
    Route::get('{id}', [ProductEquivalentController::class, 'show']);
    Route::post('/', [ProductEquivalentController::class, 'store']);
    Route::put('{id}', [ProductEquivalentController::class, 'update']);
});

// State
Route::prefix('states')->group(function () {
    Route::get('/', [StateController::class, 'index']);
    Route::get('check', [StateController::class, 'check']);
    Route::get('{id}', [StateController::class, 'show']);
    Route::post('/', [StateController::class, 'store']);
    Route::put('{id}', [StateController::class, 'update']);
});

// Steel Type
Route::prefix('steel-types')->group(function () {
    Route::get('/', [SteelTypeController::class, 'index']);
    Route::get('check', [SteelTypeController::class, 'check']);
    Route::get('{id}', [SteelTypeController::class, 'show']);
    Route::post('/', [SteelTypeController::class, 'store']);
    Route::put('{id}', [SteelTypeController::class, 'update']);
});

// UOM
Route::prefix('uoms')->group(function () {
    Route::get('/', [UOMController::class, 'index']);
    Route::get('check', [UOMController::class, 'check']);
    Route::get('{id}', [UOMController::class, 'show']);
    Route::post('/', [UOMController::class, 'store']);
    Route::put('{id}', [UOMController::class, 'update']);
});

// Vehicle
Route::prefix('vehicles')->group(function () {
    Route::get('/', [VehicleController::class, 'index']);
    Route::get('check', [VehicleController::class, 'check']);
    Route::get('license-number/{licenseNumber}', [VehicleController::class, 'findByLicenseNumber']);
    Route::get('{id}', [VehicleController::class, 'show']);
    Route::post('/', [VehicleController::class, 'store']);
    Route::put('{id}', [VehicleController::class, 'update']);
});

Route::prefix('warehouses')->group(function () {
    Route::get('/', [WarehouseController::class, 'index']);
    Route::get('check', [WarehouseController::class, 'check']);
    Route::get('{id}', [WarehouseController::class, 'show']);
    Route::post('/', [WarehouseController::class, 'store']);
    Route::put('{id}', [WarehouseController::class, 'update']);
    Route::delete('{id}', [WarehouseController::class, 'delete']);
});

Route::prefix('workcenters')->group(function () {
    Route::get('/', [WorkcenterController::class, 'index']);
    Route::get('check', [WorkcenterController::class, 'check']);
    Route::get('{id}', [WorkcenterController::class, 'show']);
    Route::post('/', [WorkcenterController::class, 'store']);
    Route::put('{id}', [WorkcenterController::class, 'update']);
    Route::delete('{id}', [WorkcenterController::class, 'delete']);
});
