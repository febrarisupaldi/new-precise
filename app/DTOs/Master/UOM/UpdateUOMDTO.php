<?php

namespace App\DTOs\Master\UOM;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateUOMDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $uom_code,
        public readonly string $uom_name,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            uom_code: (string) $data['uom_code'],
            uom_name: (string) $data['uom_name'],
            is_active: (bool) $data['is_active'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
