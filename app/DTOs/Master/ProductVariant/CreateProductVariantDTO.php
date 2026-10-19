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
        public readonly ?string $product_variant_description,
        public readonly int $product_item_id,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            product_variant_code: (string) $request->input('product_variant_code'),
            product_variant_name: (string) $request->input('product_variant_name'),
            product_variant_description: (string) $request->input('product_variant_description'),
            product_item_id: (int) $request->input('product_item_id'),
            is_active: (bool) $request->input('is_active'),
            created_by: (string) $request->input('created_by')
        );
    }
}
