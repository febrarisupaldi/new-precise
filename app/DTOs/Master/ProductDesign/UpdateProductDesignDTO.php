<?php

namespace App\DTOs\Master\ProductDesign;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductDesignDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $design_code,
        public readonly string $design_name,
        public readonly ?string $design_description,
        public readonly ?int $appearance_id,
        public readonly ?int $license_type_id,
        public readonly int $color_type_id,
        public readonly ?string $polos_printing,
        public readonly ?string $color_type,
        public readonly ?string $color_group,
        public readonly ?string $order_type,
        public readonly ?string $material_group,
        public readonly ?bool $is_active_sell,
        public readonly ?bool $is_active_production,
        public readonly ?bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            design_code: (string) $data['design_code'],
            design_name: (string) $data['design_name'],
            design_description: (string) $data['design_description'],
            appearance_id: (int) $data['appearance_id'],
            license_type_id: (int) $data['license_type_id'],
            color_type_id: (int) $data['color_type_id'],
            polos_printing: (string) $data['polos_printing'],
            color_type: (string) $data['color_type'],
            color_group: (string) $data['color_group'],
            order_type: (string) $data['order_type'],
            material_group: (string) $data['material_group'],
            is_active_sell: (bool) $data['is_active_sell'],
            is_active_production: (bool) $data['is_active_production'],
            is_active: (bool) $data['is_active'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
