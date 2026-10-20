<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingDetailDTO extends BaseDTO
{
    public function __construct(
        public readonly int $packaging_id,
        public readonly ?int $product_id,
        public readonly ?int $item_id,
        public readonly ?string $item_code,
        public readonly int $product_qty,
        public readonly ?int $priority,
        public readonly ?int $usage_per_unit,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            packaging_id: (int) $data['packaging_id'],
            product_id: (int) $data['product_id'],
            item_id: (int) $data['item_id'],
            item_code: (string) $data['item_code'],
            product_qty: (int) $data['product_qty'],
            priority: (int) $data['priority'],
            usage_per_unit: (int) $data['usage_per_unit'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
