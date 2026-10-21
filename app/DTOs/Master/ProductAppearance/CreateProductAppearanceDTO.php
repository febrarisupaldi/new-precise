<?php

namespace App\DTOs\Master\ProductAppearance;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductAppearanceDTO extends BaseDTO
{

    public function __construct(
        public readonly string $appearance_name,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            appearance_name: (string) $data['appearance_name'],
            created_by: (string) $data['created_by']
        );
    }
}
