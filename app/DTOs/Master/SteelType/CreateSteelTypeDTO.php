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

    public static function fromArray(array $data): static
    {
        return new static(
            steel_type_name: (string) $data['steel_type_name'],
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }
}
