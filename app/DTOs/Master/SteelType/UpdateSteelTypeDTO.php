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

    public static function fromRequest(Request $request): static
    {
        return new static(
            steel_type_name: (string) $request->input('steel_type_name'),
            is_active: (bool) $request->input('is_active'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
