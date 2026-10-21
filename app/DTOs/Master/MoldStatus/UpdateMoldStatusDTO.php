<?php

namespace App\DTOs\Master\MoldStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMoldStatusDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $status_code,
        public readonly string $status_description,
        public readonly bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            status_code: (string) $data['status_code'],
            status_description: (string) $data['status_description'],
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
