<?php

namespace App\DTOs\Master\ProductType;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductTypeDTO extends BaseDTO
{

    public function __construct(
        public readonly string $product_type_code,
        public readonly string $product_type_name,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            product_type_code: (string) $data['product_type_code'],
            product_type_name: (string) $data['product_type_name'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
