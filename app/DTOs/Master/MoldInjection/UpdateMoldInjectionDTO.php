<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldInjectionDTO extends BaseDTO
{

    use AuditDTO;

    public function __construct(
        public readonly string $mold_number,
        public readonly string $mmit_code_dont_use,
        public readonly string $mold_name,
        public readonly ?bool $is_family_mold,
        public readonly ?int $customer_id,
        public readonly string $status_code,
        public readonly ?string $remake_from,
        public readonly ?string $production_date,
        public readonly ?int $tonnage_std,
        public readonly ?int $tonnage_min,
        public readonly ?int $tonnage_max,
        public readonly ?int $steel_type_id,
        public readonly ?int $mold_making_id,
        public readonly ?string $mold_maker,
        public readonly ?int $cooling_method_id,
        public readonly ?string $mold_description,
        public readonly ?int $length,
        public readonly ?int $width,
        public readonly ?int $height,
        public readonly ?string $dimension_uom,
        public readonly ?int $plate_size_length,
        public readonly ?int $plate_size_width,
        public readonly ?string $plate_size_uom,
        public readonly string $updated_by,
        public readonly string $reason,
        public readonly array $details
    ) {}



    public static function fromArray(array $data): static
    {
        $details = collect(
            $data['details'] ?? []
        )->map(fn(array $detail) => UpdateMoldInjectionDetailDTO::fromArray($detail))->toArray();

        return new static(
            mold_number: (string) $data['mold_number'],
            mmit_code_dont_use: (string) $data['mmit_code_dont_use'],
            mold_name: (string) $data['mold_name'],
            is_family_mold: (bool) $data['is_family_mold'],
            customer_id: (int) $data['customer_id'],
            status_code: (string) $data['status_code'],
            remake_from: (string) $data['remake_from'],
            production_date: (string) $data['production_date'],
            tonnage_std: (int) $data['tonnage_std'],
            tonnage_min: (int) $data['tonnage_min'],
            tonnage_max: (int) $data['tonnage_max'],
            steel_type_id: (int) $data['steel_type_id'],
            mold_making_id: (int) $data['mold_making_id'],
            mold_maker: (string) $data['mold_maker'],
            cooling_method_id: (int) $data['cooling_method_id'],
            mold_description: (string) $data['mold_description'],
            length: (int) $data['length'],
            width: (int) $data['width'],
            height: (int) $data['height'],
            dimension_uom: (string) $data['dimension_uom'],
            plate_size_length: (int) $data['plate_size_length'],
            plate_size_width: (int) $data['plate_size_width'],
            plate_size_uom: (string) $data['plate_size_uom'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason'],
            details: $details
        );
    }
}
