<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdatePackagingDetailDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly ?int $packaging_dt_id,
        public readonly ?int $product_id,
        public readonly ?int $item_id,
        public readonly string $item_code,
        public readonly int $product_qty,
        public readonly int $priority,
        public readonly ?int $usage_per_unit,
        public readonly string $updated_by
    ) {}
    public static function fromArray(array $data): static
    {
        return new static(
            packaging_dt_id: (int) $data['packaging_dt_id'] ?? null,
            product_id: (int) $data['product_id'] ?? null,
            item_id: (int) $data['item_id'] ?? null,
            item_code: (string) $data['item_code'],
            product_qty: (int) $data['product_qty'],
            priority: (int) $data['priority'],
            usage_per_unit: (int) $data['usage_per_unit'] ?? null,
            updated_by: (string) $data['updated_by']
        );
    }
}
