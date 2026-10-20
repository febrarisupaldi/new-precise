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

    public static function fromArray(array $data): static
    {
        return new static(
            vehicle_model: (string) $data['vehicle_model'],
            license_number: (string) $data['license_number'],
            vehicle_description: (string) $data['vehicle_description'],
            is_owned: (bool) $data['is_owned'],
            is_active: (bool) $data['is_active'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
