<?php

namespace App\Http\Requests\Master\SteelType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateSteelTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'steel_type_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('steel_type')->ignore($this->steel_type_name, 'steel_type_name')
            ],
            'is_active'       => ['nullable', 'boolean'],
            'updated_by'      => ['required', 'string', 'max:100'],
            'reason'          => ['required', 'string'],
        ];
    }
}
