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

    public static function fromRequest(Request $request): static
    {
        return new static(
            product_type_code: (string) $request->input('product_type_code'),
            product_type_name: (string) $request->input('product_type_name'),
            created_by: (string) $request->input('created_by')
        );
    }
}
