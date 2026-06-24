<?php

namespace App\Http\Requests\Master\SteelType;

use App\Http\Requests\BaseApiRequest;

class CreateSteelTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'steel_type_name' => ['required', 'string', 'max:100', 'unique:steel_type,steel_type_name'],
            'is_active'       => ['nullable', 'boolean'],
            'created_by'      => ['required', 'string', 'max:100'],
        ];
    }
}
