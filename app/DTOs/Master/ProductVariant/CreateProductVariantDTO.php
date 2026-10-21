<?php

namespace App\DTOs\Master\ProductVariant;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductVariantDTO extends BaseDTO
{
    // Define properties here
    public function __construct(
        public readonly string $product_variant_code,
        public readonly string $product_variant_name,
        public readonly string $product_variant_description,
        public readonly int $product_item_id,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            product_variant_code: (string) $data['product_variant_code'],
            product_variant_name: (string) $data['product_variant_name'],
            product_variant_description: (string) $data['product_variant_description'],
            product_item_id: (int) $data['product_item_id'],
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }
}
