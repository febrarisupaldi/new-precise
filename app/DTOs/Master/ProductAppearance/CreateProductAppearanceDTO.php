<?php

namespace App\DTOs\Master\ProductAppearance;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductAppearanceDTO extends BaseDTO
{

    public function __construct(
        public readonly ?string $appearance_name,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            appearance_name: (string) $request->input('appearance_name'),
            created_by: (string) $request->input('created_by')
        );
    }
}
