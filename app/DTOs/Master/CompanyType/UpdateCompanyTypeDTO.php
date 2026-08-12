<?php

namespace App\DTOs\Master\CompanyType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCompanyTypeDTO extends BaseDTO
{
    use AuditDTO;

    public string $company_type_code;
    public ?string $company_type_description;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->company_type_code        = $request->input('company_type_code');
        $dto->company_type_description = $request->input('company_type_description');
        $dto->updated_by               = $request->input('updated_by');
        $dto->reason                   = $request->input('reason');
        return $dto;
    }
}
