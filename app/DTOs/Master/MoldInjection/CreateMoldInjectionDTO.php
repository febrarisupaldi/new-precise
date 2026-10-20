<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldInjectionDTO extends BaseDTO
{
    public function __construct(
        public readonly string $mold_number,
        public readonly ?string $mmit_code_dont_use,
        public readonly string $mold_name,
        public readonly ?bool $is_family_mold,
        public readonly ?int $customer_id,
        public readonly string $status_code,
        public readonly ?int $remake_from,
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
        public readonly string $created_by,
        public readonly array $details
    ) {}



    public static function fromArray(
        array $data
    ): static {

        $details = collect(
            $data['details'] ?? []
        )
            ->map(
                fn(array $detail) =>
                CreateMoldInjectionDetailDTO::fromArray(
                    $detail
                )
            )
            ->toArray();

        return new static(
            mold_number: (string) $data['mold_number'],
            mmit_code_dont_use: (string) $data['mmit_code_dont_use'] ?? null,
            mold_name: (string) $data['mold_name'],
            is_family_mold: (bool) $data['is_family_mold'],
            customer_id: (int) $data['customer_id'] ?? null,
            status_code: (string) $data['status_code'],
            remake_from: (int) $data['remake_from'] ?? null,
            production_date: (string) $data['production_date'] ?? null,
            tonnage_std: (int) $data['tonnage_std'] ?? null,
            tonnage_min: (int) $data['tonnage_min'] ?? null,
            tonnage_max: (int) $data['tonnage_max'] ?? null,
            steel_type_id: (int) $data['steel_type_id'] ?? null,
            mold_making_id: (int) $data['mold_making_id'] ?? null,
            mold_maker: (string) $data['mold_maker'] ?? null,
            cooling_method_id: (int) $data['cooling_method_id'] ?? null,
            mold_description: (string) $data['mold_description'] ?? null,
            length: (int) $data['length'] ?? null,
            width: (int) $data['width'] ?? null,
            height: (int) $data['height'] ?? null,
            dimension_uom: (string) $data['dimension_uom'] ?? null,
            plate_size_length: (int) $data['plate_size_length'] ?? null,
            plate_size_width: (int) $data['plate_size_width'] ?? null,
            plate_size_uom: (string) $data['plate_size_uom'] ?? null,
            created_by: (string) $data['created_by'],
            details: $details
        );
    }
}
