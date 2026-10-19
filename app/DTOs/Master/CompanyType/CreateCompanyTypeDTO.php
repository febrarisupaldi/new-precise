<?php

namespace App\DTOs\Master\CompanyType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCompanyTypeDTO extends BaseDTO
{

    public function __construct(
        public readonly string $company_type_code,
        public readonly ?string $company_type_description,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            company_type_code: (string) $data['company_type_code'],
            company_type_description: (string) $data['company_type_description'] ?? null,
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
