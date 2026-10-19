<?php

namespace App\DTOs\Master\SteelType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSteelTypeDTO extends BaseDTO
{
    public function __construct(
        public readonly string $steel_type_name,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            steel_type_name: (string) $request->input('steel_type_name'),
            is_active: (bool) $request->input('is_active') ?? true,
            created_by: (string) $request->input('created_by')
        );
    }
}
