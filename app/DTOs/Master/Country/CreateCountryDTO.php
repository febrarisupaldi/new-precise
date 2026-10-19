<?php

namespace App\DTOs\Master\Country;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCountryDTO extends BaseDTO
{
    public function __construct(
        public readonly string $country_code,
        public readonly string $country_name,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            country_code: (string) $data['country_code'],
            country_name: (string) $data['country_name'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
