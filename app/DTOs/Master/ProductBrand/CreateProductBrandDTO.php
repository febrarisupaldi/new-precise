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

    public static function fromArray(array $data): static
    {
        return new static(
            product_brand_name: (string) $data['product_brand_name'],
            is_active: (bool) $data['is_active'],
            created_by: (string) $data['created_by']
        );
    }
}
