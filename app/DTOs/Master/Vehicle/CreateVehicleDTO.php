<?php

namespace App\DTOs\Master\Vehicle;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateVehicleDTO extends BaseDTO
{
    // Define properties here
    public string $vehicle_model;
    public string $license_number;
    public string $vehicle_description;
    public int $is_owned;
    public int $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->vehicle_model = $request->input('vehicle_model');
        $dto->license_number = $request->input('license_number');
        $dto->vehicle_description = $request->input('vehicle_description');
        $dto->is_owned = $request->input('is_owned');
        $dto->is_active = $request->input('is_active', 1);
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
