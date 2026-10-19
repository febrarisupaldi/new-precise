<?php

namespace App\DTOs\Master\City;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCityDTO extends BaseDTO
{

    public function __construct(
        public readonly string $city_code,
        public readonly string $city_name,
        public readonly string $state_id,
        public readonly string $created_by
    ) {}


    public static function fromArray(array $data): static
    {
        return new static(
            city_code: (string) $data['city_code'],
            city_name: (string) $data['city_name'],
            state_id: (string) $data['state_id'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
