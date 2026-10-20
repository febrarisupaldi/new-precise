<?php

namespace App\DTOs\Master\State;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateStateDTO extends BaseDTO
{
    public function __construct(
        public readonly string $state_code,
        public readonly string $state_name,
        public readonly int $country_id,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            state_code: (string) $data['state_code'],
            state_name: (string) $data['state_name'],
            country_id: (int) $data['country_id'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
