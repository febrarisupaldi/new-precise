<?php

namespace App\DTOs\Master\Vehicle;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateVehicleDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $vehicle_model,
        public readonly string $license_number,
        public readonly string $vehicle_description,
        public readonly bool $is_owned,
        public readonly ?bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new static(
            vehicle_model: (string) $request->input('vehicle_model'),
            license_number: (string) $request->input('license_number'),
            vehicle_description: (string) $request->input('vehicle_description'),
            is_owned: (bool) $request->input('is_owned'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
