<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateWorkcenterDTO extends BaseDTO
{

    public function __construct(
        public readonly string $workcenter_code,
        public readonly string $workcenter_name,
        public readonly ?string $workcenter_description,
        public readonly ?int $default_warehouse,
        public readonly string $production_type,
        public readonly int $production_center,
        public readonly ?int $subprocess_level,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            workcenter_code: (string) strtoupper($data['workcenter_code']),
            workcenter_name: (string) $data['workcenter_name'],
            workcenter_description: (string) $data['workcenter_description'] ?? null,
            default_warehouse: (int) $data['default_warehouse'] ?? null,
            production_type: (string) $data['production_type'],
            production_center: (int) $data['production_center'],
            subprocess_level: (int) $data['subprocess_level'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }
}
