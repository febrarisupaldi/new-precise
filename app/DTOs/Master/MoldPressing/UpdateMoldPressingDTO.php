<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;

class UpdateMoldPressingDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $mold_number,
        public readonly string $mold_code,
        public readonly ?string $mold_group,
        public readonly ?string $mold_rack,
        public readonly ?string $mold_location,
        public readonly string $item_code,
        public readonly int $default_tonnage,
        public readonly ?string $mold_description,
        public readonly string $mold_status_code,
        public readonly ?int $mold_parent_id,
        public readonly string $production_date,
        public readonly ?int $mold_making_id,
        public readonly ?string $mold_maker,
        public readonly string $updated_by,
        public readonly string $reason,
        public readonly array $details,
        public readonly array $detail_delete_ids,
    ) {}

    public static function fromArray(array $data): static
    {
        $details = collect(
            $data['details'] ?? []
        )->map(
            fn(array $detail) => UpdateMoldPressingDetailDTO::fromArray($detail)
        )->toArray();

        return new static(
            mold_number: (string) $data['mold_number'],
            mold_code: (string) $data['mold_code'],
            mold_group: (string) $data['mold_group'] ?? '',
            mold_rack: (string) $data['mold_rack'] ?? null,
            mold_location: (string) $data['mold_location'] ?? null,
            item_code: (string) $data['item_code'] ?? '',
            default_tonnage: (int) $data['default_tonnage'] ?? 0,
            mold_description: (string) $data['mold_description'] ?? null,
            mold_status_code: (string) $data['mold_status_code'],
            mold_parent_id: (int) $data['mold_parent_id'] ?? null,
            production_date: (string) $data['production_date'],
            mold_making_id: (int) $data['mold_making_id'] ?? null,
            mold_maker: (string) $data['mold_maker'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason'],
            details: (array) $details,
            detail_delete_ids: (array) ($data['detail_delete_ids'] ?? []),
        );
    }
}
