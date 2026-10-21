<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMoldInjectionDetailCavityDTO extends BaseDTO
{

    public function __construct(
        public readonly ?int $mold_injection_cavity_id,
        public readonly int $mold_injection_dt_id,
        public readonly int $cavity_number,
        public readonly int $qty_set,
        public readonly int $cavity_active_per_set,
        public readonly int $cavity_total,
        public readonly int $product_weight,
        public readonly string $product_weight_uom,
        public readonly ?bool $is_active,
        public readonly string $updated_by,
    ) {}



    public static function fromArray(array $data): static
    {
        return new static(
            mold_injection_cavity_id: (int) $data['mold_injection_cavity_id'] ?? null,
            mold_injection_dt_id: (int) $data['mold_injection_dt_id'],
            cavity_number: (int) $data['cavity_number'],
            qty_set: (int) $data['qty_set'],
            cavity_active_per_set: (int) $data['cavity_active_per_set'],
            cavity_total: (int) $data['cavity_total'],
            product_weight: (int) $data['product_weight'],
            product_weight_uom: (string) $data['product_weight_uom'],
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by']
        );
    }
}
