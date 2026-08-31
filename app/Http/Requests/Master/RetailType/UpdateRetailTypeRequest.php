<?php

namespace App\Http\Requests\Master\RetailType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateRetailTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'retail_type_code' => ['required', 'string', Rule::unique('retail_type')->ignore($this->retail_type_code, 'retail_type_code')],
            'retail_type_description' => ['required', 'string', Rule::unique('retail_type')->ignore($this->retail_type_description, 'retail_type_description')],
            'GroupCodeOnProint' => ['required', 'string', Rule::unique('retail_type')->ignore($this->groupcodeonproint, 'groupcodeonproint')],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
