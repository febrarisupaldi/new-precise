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

    public static function fromRequest(Request $request): static
    {
        return new static(
            state_code: (string) $request->input('state_code'),
            state_name: (string) $request->input('state_name'),
            country_id: (int) $request->input('country_id'),
            created_by: (string) $request->input('created_by')
        );
    }
}
