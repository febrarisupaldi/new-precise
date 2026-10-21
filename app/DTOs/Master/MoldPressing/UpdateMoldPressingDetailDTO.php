<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldPressingDetailDTO extends BaseDTO
{

    use AuditDTO;

    public function __construct(
        public readonly ?int $mold_pressing_dt_id,
        public readonly ?int $mold_pressing_hd_id,
        public readonly ?string $mold_code,
        public readonly ?string $cavity_number,
        public readonly ?string $product_weight,
        public readonly ?string $product_weight_uom,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromArray(array $data): static
    {
        return new static(
            mold_pressing_dt_id: (int) $data['mold_pressing_dt_id'] ?? null,
            mold_pressing_hd_id: (int) $data['mold_pressing_hd_id'] ?? null,
            mold_code: (string) $data['mold_code'] ?? null,
            cavity_number: (string) $data['cavity_number'] ?? null,
            product_weight: (string) $data['product_weight'] ?? null,
            product_weight_uom: (string) $data['product_weight_uom'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
