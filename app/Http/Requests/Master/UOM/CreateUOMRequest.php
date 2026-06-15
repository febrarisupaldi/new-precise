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
            'uom_code' => ['required', 'string'],
            'uom_name' => ['required', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'created_by' => ['required', 'string'],
        ];
    }
}
