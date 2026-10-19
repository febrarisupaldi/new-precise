<?php

namespace App\DTOs\Master\City;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCityDTO extends BaseDTO
{

    use AuditDTO;
    // Define properties here

    public function __construct(
        public readonly string $city_code,
        public readonly string $city_name,
        public readonly string $state_id,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            city_code: (string) $data['city_code'],
            city_name: (string) $data['city_name'],
            state_id: (string) $data['state_id'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
