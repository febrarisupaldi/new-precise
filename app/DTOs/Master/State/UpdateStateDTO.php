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

    public static function fromRequest(Request $request): static
    {
        return new static(
            state_code: (string) $request->input('state_code'),
            state_name: (string) $request->input('state_name'),
            country_id: (int) $request->input('country_id'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
