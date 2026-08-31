<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Engineering\MachinePressingActivityController;

// Tambahkan route module engineering di bawah ini

Route::prefix("machine-pressing-activities")->group(function () {
    Route::get("/", [MachinePressingActivityController::class, "index"]);
    Route::post("/", [MachinePressingActivityController::class, "store"]);
    Route::delete("/{id}", [MachinePressingActivityController::class, "destroy"]);
});
