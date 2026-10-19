<?php

namespace App\DTOs\Master\ColorType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateColorTypeDTO extends BaseDTO
{

    public function __construct(
        public readonly string $color_type_code,
        public readonly string $color_type_name,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            color_type_code: (string) $data['color_type_code'],
            color_type_name: (string) $data['color_type_name'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
