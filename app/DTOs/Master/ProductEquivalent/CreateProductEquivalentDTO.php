<?php

namespace App\DTOs\Master\ProductEquivalent;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductEquivalentDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public function __construct(
        public readonly string $product_code,
        public readonly string $uom_code,
        public readonly int $qty_std,
        public readonly int $qty_conversion,
        public readonly string $updated_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            product_code: (string) $request->input('product_code'),
            uom_code: (string) $request->input('uom_code'),
            qty_std: (int) $request->input('qty_std'),
            qty_conversion: (int) $request->input('qty_conversion'),
            updated_by: (string) $request->input('updated_by')
        );
    }
}
