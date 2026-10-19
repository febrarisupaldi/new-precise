<?php

namespace App\DTOs\Master\ProductBrand;


use App\DTOs\Traits\AuditDTO;
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductBrandDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $product_brand_name,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            product_brand_name: (string) $request->input('product_brand_name'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
