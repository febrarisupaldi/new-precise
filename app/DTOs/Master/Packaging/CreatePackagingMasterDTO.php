<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingMasterDTO extends BaseDTO
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
        public readonly string $created_by
    ) {}



    public static function fromRequest(Request $request): static
    {
        return new static(
            packaging_id: (int) $request->input('packaging_id'),
            packaging_alias: (string) $request->input('packaging_alias'),
            inner_length: (int) $request->input('inner_length'),
            inner_width: (int) $request->input('inner_width'),
            inner_height: (int) $request->input('inner_height'),
            outer_length: (int) $request->input('outer_length'),
            outer_width: (int) $request->input('outer_width'),
            outer_height: (int) $request->input('outer_height'),
            dimension_uom_code: (string) $request->input('dimension_uom_code'),
            weight: (int) $request->input('weight'),
            weight_uom_code: (string) $request->input('weight_uom_code'),
            packaging_spec: (string) $request->input('packaging_spec'),
            max_stack: (int) $request->input('max_stack'),
            is_active: (int) $request->input('is_active'),
            created_by: (string) $request->input('created_by')
        );
    }
}
