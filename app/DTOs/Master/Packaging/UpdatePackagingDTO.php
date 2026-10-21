<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdatePackagingDTO extends BaseDTO
{

    public function __construct(
        public readonly ?string $packaging_alias,
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
        public readonly ?bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason,
        public readonly array $details,
        public readonly ?array $delete_detail_ids
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            packaging_alias: (string) $data['packaging_alias'] ?? null,
            inner_length: (int) $data['inner_length'] ?? null,
            inner_width: (int) $data['inner_width'] ?? null,
            inner_height: (int) $data['inner_height'] ?? null,
            outer_length: (int) $data['outer_length'] ?? null,
            outer_width: (int) $data['outer_width'] ?? null,
            outer_height: (int) $data['outer_height'] ?? null,
            dimension_uom_code: (string) $data['dimension_uom_code'] ?? null,
            weight: (int) $data['weight'] ?? null,
            weight_uom_code: (string) $data['weight_uom_code'] ?? null,
            packaging_spec: (string) $data['packaging_spec'] ?? null,
            max_stack: (int) $data['max_stack'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason'],
            details: (array) $data['details'],
            delete_detail_ids: (array) $data['delete_detail_ids'] ?? []
        );
    }
}
