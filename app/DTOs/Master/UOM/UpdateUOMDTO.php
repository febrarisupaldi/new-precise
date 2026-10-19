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

    public static function fromRequest(Request $request): static
    {
        return new static(
            uom_code: (string) $request->input('uom_code'),
            uom_name: (string) $request->input('uom_name'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
