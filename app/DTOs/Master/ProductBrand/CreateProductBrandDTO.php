<?php

namespace App\DTOs\Master\ProductBrand;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductBrandDTO extends BaseDTO
{

    public function __construct(
        public readonly string $product_brand_name,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            product_brand_name: (string) $request->input('product_brand_name'),
            is_active: (bool) $request->input('is_active'),
            created_by: (string) $request->input('created_by')
        );
    }
}
