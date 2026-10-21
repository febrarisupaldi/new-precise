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

    public static function fromArray(array $data): static
    {
        return new static(
            product_brand_name: (string) $data['product_brand_name'],
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
