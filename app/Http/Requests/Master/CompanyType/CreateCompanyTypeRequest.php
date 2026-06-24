<?php

namespace App\Http\Requests\Master\CompanyType;

use App\Http\Requests\BaseApiRequest;

class CreateCompanyTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_type_code'        => ['required', 'max:15', 'unique:company_type,company_type_code'],
            'company_type_description' => ['nullable', 'string', 'max:100'],
            'created_by'               => ['required', 'string', 'max:100'],
        ];
    }
}
