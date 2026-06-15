<?php

namespace App\Http\Requests\Master\UOM;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateUOMRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'uom_code' => ['required', 'string', Rule::unique('uom', 'uom_code')->ignore($this->uom_code, 'uom_code')],
            'uom_name' => ['required', 'string', Rule::unique('uom', 'uom_name')->ignore($this->uom_name, 'uom_name')],
            'is_active' => ['nullable', 'boolean'],
            'updated_by' => ['required', 'string'],
            'reason' => ['required', 'string', 'max:255'],
        ];
    }
}
