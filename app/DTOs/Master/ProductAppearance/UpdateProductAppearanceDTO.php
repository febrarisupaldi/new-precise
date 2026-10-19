<?php

namespace App\DTOs\Master\ProductAppearance;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductAppearanceDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly ?string $appearance_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            appearance_name: (string) $request->input('appearance_name'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
