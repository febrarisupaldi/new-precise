<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateWorkcenterDTO extends BaseDTO
{
    // Define properties here

    use AuditDTO;

    public function __construct(
        public readonly string $workcenter_code,
        public readonly string $workcenter_name,
        public readonly ?string $workcenter_description,
        public readonly ?int $default_warehouse,
        public readonly ?string $production_type,
        public readonly ?string $production_center,
        public readonly ?int $subprocess_level,
        public readonly ?bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            workcenter_code: (string) strtoupper($data['workcenter_code']),
            workcenter_name: (string) $data['workcenter_name'],
            workcenter_description: (string) $data['workcenter_description'],
            default_warehouse: (int) $data['default_warehouse'],
            production_type: (string) $data['production_type'],
            production_center: (string) $data['production_center'],
            subprocess_level: (int) $data['subprocess_level'],
            is_active: (bool) $data['is_active'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
