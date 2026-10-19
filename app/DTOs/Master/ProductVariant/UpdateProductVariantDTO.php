<?php

namespace App\DTOs\Master\ProductVariant;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductVariantDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly int $product_variant_id,
        public readonly string $product_variant_code,
        public readonly string $product_variant_name,
        public readonly ?string $product_variant_description,
        public readonly int $product_item_id,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            product_variant_id: (int) $request->input('product_variant_id'),
            product_variant_code: (string) $request->input('product_variant_code'),
            product_variant_name: (string) $request->input('product_variant_name'),
            product_variant_description: (string) $request->input('product_variant_description'),
            product_item_id: (int) $request->input('product_item_id'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
