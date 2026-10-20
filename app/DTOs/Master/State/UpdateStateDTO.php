<?php

namespace App\DTOs\Master\State;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateStateDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $state_code,
        public readonly string $state_name,
        public readonly int $country_id,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            state_code: (string) $data['state_code'],
            state_name: (string) $data['state_name'],
            country_id: (int) $data['country_id'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
