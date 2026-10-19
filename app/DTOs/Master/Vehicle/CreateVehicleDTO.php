<?php

namespace App\DTOs\Master\Vehicle;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateVehicleDTO extends BaseDTO
{
    public function __construct(
        public readonly string $vehicle_model,
        public readonly string $license_number,
        public readonly string $vehicle_description,
        public readonly int $is_owned,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            vehicle_model: (string) $request->input('vehicle_model'),
            license_number: (string) $request->input('license_number'),
            vehicle_description: (string) $request->input('vehicle_description'),
            is_owned: (int) $request->input('is_owned'),
            is_active: (bool) $request->input('is_active', true),
            created_by: (string) $request->input('created_by')
        );
    }
}
