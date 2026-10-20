<?php

namespace App\DTOs\Master\SteelType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateSteelTypeDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $steel_type_name,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            steel_type_name: (string) $data['steel_type_name'],
            is_active: (bool) $data['is_active'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
