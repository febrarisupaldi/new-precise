<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldPressingDetailDTO extends BaseDTO
{
    public function __construct(
        public readonly string $mold_pressing_hd_id,
        public readonly string $mold_code,
        public readonly string $cavity_number,
        public readonly ?string $product_weight,
        public readonly ?string $product_weight_uom,
        public readonly ?bool $is_active,
        public readonly string $created_by,
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            mold_pressing_hd_id: (string) $request->input('mold_pressing_hd_id'),
            mold_code: (string) $request->input('mold_code'),
            cavity_number: (string) $request->input('cavity_number'),
            product_weight: (string) $request->input('product_weight'),
            product_weight_uom: (string) $request->input('product_weight_uom'),
            is_active: (bool) $request->input('is_active'),
            created_by: (string) $request->input('created_by')
        );
    }
}
