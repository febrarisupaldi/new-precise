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

    public static function fromRequest(Request $request): static
    {
        return new static(
            status_code: (string) $request->input('status_code'),
            status_description: (string) $request->input('status_description'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
