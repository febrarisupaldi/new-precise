<?php

namespace App\DTOs\Master\ProductLicenseType;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductLicenseTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $license_type_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            license_type_name: (string) $request->input('license_type_name'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
