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

    public static function fromArray(array $data): static
    {
        return new static(
            license_type_name: (string) $data['license_type_name'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
