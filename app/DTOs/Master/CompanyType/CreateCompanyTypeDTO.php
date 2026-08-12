<?php

namespace App\DTOs\Master\CompanyType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCompanyTypeDTO extends BaseDTO
{
    public string $company_type_code;
    public ?string $company_type_description;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->company_type_code        = $request->input('company_type_code');
        $dto->company_type_description = $request->input('company_type_description');
        $dto->created_by               = $request->input('created_by');
        return $dto;
    }
}
