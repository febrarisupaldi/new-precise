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

    public static function fromArray(array $data): static
    {
        return new static(
            product_type_code: (string) $data['product_type_code'],
            product_type_name: (string) $data['product_type_name'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
