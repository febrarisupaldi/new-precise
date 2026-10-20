<?php

namespace App\DTOs\Master\CompanyType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCompanyTypeDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $company_type_code,
        public readonly ?string $company_type_description,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            company_type_code: (string) $data['company_type_code'],
            company_type_description: (string) $data['company_type_description'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
