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

    public static function fromArray(array $data): static
    {
        return new static(
            product_code: (string) $data['product_code'],
            uom_code: (string) $data['uom_code'],
            qty_std: (int) $data['qty_std'],
            qty_conversion: (int) $data['qty_conversion'],
            updated_by: (string) $data['updated_by']
        );
    }
}
