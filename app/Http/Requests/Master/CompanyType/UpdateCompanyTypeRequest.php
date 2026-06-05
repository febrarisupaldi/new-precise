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
            'company_type_name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('company_type')->ignore($this->company_type_name, 'company_type_name')
            ],
            'company_type_description' => ['nullable', 'string'],
            'updated_by'               => ['required', 'string', 'max:255'],
            'reason'                   => ['required', 'string'],
        ];
    }
}
