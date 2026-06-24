<?php

namespace App\Http\Requests\Master\CompanyType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateCompanyTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_type_code'        => [
                'required',
                'string',
                'max:15',
                Rule::unique('company_type')->ignore($this->company_type_code, 'company_type_code')
            ],
            'company_type_description' => ['nullable', 'string', 'max:100'],
            'updated_by'               => ['required', 'string', 'max:100'],
            'reason'                   => ['required', 'string'],
        ];
    }
}
