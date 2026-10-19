<?php

namespace App\DTOs\Master\ProductType;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $product_type_code,
        public readonly string $product_type_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            product_type_code: (string) $request->input('product_type_code'),
            product_type_name: (string) $request->input('product_type_name'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
