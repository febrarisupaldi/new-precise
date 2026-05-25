<?php

namespace App\DTOs\Master\Vehicle;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateVehicleDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here
    // public $property;
    public string $vehicle_model;
    public string $license_number;
    public string $vehicle_description;
    public int $is_owned;
    public int $is_active;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): self
    {
        $dto = new self();
        $dto->vehicle_model = $request->input('vehicle_model');
        $dto->license_number = $request->input('license_number');
        $dto->vehicle_description = $request->input('vehicle_description');
        $dto->is_owned = $request->input('is_owned');
        $dto->is_active = $request->input('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');
        return $dto;
    }
}
