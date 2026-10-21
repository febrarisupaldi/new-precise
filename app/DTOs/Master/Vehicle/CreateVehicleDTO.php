<?php

namespace App\DTOs\Master\Vehicle;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateVehicleDTO extends BaseDTO
{
    public function __construct(
        public readonly string $vehicle_model,
        public readonly string $license_number,
        public readonly ?string $vehicle_description,
        public readonly ?int $is_owned,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            vehicle_model: (string) $data['vehicle_model'],
            license_number: (string) $data['license_number'],
            vehicle_description: (string) $data['vehicle_description'],
            is_owned: isset($data['is_owned']) ? (int) $data['is_owned'] : null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }
}
