<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldPressingDetailDTO extends BaseDTO
{
    public function __construct(
        public readonly ?int $mold_pressing_hd_id,
        public readonly ?string $mold_code,
        public readonly string $cavity_number,
        public readonly ?string $product_weight,
        public readonly ?string $product_weight_uom,
        public readonly ?bool $is_active,
        public readonly string $created_by,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            mold_pressing_hd_id: null,
            mold_code: (string) $data['mold_code'] ?? null,
            cavity_number: (string) $data['cavity_number'],
            product_weight: (string) $data['product_weight'] ?? null,
            product_weight_uom: (string) $data['product_weight_uom'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }

    public function withMoldPressingId(int $moldId): static
    {
        return new static(
            mold_pressing_hd_id: $moldId,
            mold_code: $this->mold_code,
            cavity_number: $this->cavity_number,
            product_weight: $this->product_weight,
            product_weight_uom: $this->product_weight_uom,
            is_active: $this->is_active,
            created_by: $this->created_by,
        );
    }
}
