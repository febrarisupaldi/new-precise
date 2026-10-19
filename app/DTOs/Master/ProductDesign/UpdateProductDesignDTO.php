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

    public static function fromRequest(Request $request): static
    {
        return new static(
            design_code: (string) $request->input('product_design_code'),
            design_name: (string) $request->input('design_name'),
            design_description: (string) $request->input('design_description'),
            appearance_id: (int) $request->input('appearance_id'),
            license_type_id: (int) $request->input('license_type_id'),
            color_type_id: (int) $request->input('color_type_id'),
            polos_printing: (string) $request->input('polos_printing'),
            color_type: (string) $request->input('color_type'),
            color_group: (string) $request->input('color_group'),
            order_type: (string) $request->input('order_type'),
            material_group: (string) $request->input('material_group'),
            is_active_sell: (bool) $request->input('is_active_sell'),
            is_active_production: (bool) $request->input('is_active_production'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
