<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingDTO extends BaseDTO
{
    public function __construct(
        public readonly int $packaging_id,
        public readonly string $packaging_alias,
        public readonly ?int $inner_length,
        public readonly ?int $inner_width,
        public readonly ?int $inner_height,
        public readonly ?int $outer_length,
        public readonly ?int $outer_width,
        public readonly ?int $outer_height,
        public readonly ?string $dimension_uom_code,
        public readonly ?int $weight,
        public readonly ?string $weight_uom_code,
        public readonly ?string $packaging_spec,
        public readonly ?int $max_stack,
        public readonly int $is_active,
        public readonly string $created_by,
        public readonly array $details
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            packaging_id: (int) $data['packaging_id'],
            packaging_alias: (string) $data['packaging_alias'],
            inner_length: (int) $data['inner_length'],
            inner_width: (int) $data['inner_width'],
            inner_height: (int) $data['inner_height'],
            outer_length: (int) $data['outer_length'],
            outer_width: (int) $data['outer_width'],
            outer_height: (int) $data['outer_height'],
            dimension_uom_code: (string) $data['dimension_uom_code'],
            weight: (int) $data['weight'],
            weight_uom_code: (string) $data['weight_uom_code'],
            packaging_spec: (string) $data['packaging_spec'],
            max_stack: (int) $data['max_stack'],
            is_active: (bool) $data['is_active'],
            created_by: (string) $data['created_by'],
            details: (array) $data['details']
        );
    }
}
