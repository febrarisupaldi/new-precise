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

    public static function fromRequest(Request $request): static
    {
        return new static(
            packaging_id: (int) $request->input("packaging_id"),
            product_id: (int) $request->input("product_id"),
            item_id: (int) $request->input("item_id"),
            item_code: (string) $request->input("item_code"),
            product_qty: (int) $request->input("product_qty"),
            priority: (int) $request->input("priority"),
            usage_per_unit: (int) $request->input("usage_per_unit"),
            created_by: (string) $request->input("created_by")
        );
    }
}
