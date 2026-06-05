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
            'company_type_name'        => ['required', 'string', 'max:255', 'unique:company_type,company_type_name'],
            'company_type_description' => ['nullable', 'string'],
            'created_by'               => ['required', 'string', 'max:255'],
        ];
    }
}
