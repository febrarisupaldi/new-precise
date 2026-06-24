<?php

namespace App\Http\Requests\Master\UOM;

use App\Http\Requests\BaseApiRequest;

class CreateUOMRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uom_code' => ['required', 'string', 'max:10'],
            'uom_name' => ['required', 'string', 'max:25'],
            'uom_coretax' => ['required', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'created_by' => ['required', 'string', 'max:100'],
        ];
    }
}
