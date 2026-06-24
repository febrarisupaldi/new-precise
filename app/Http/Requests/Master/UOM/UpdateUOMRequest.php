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
            'uom_name'      => ['required', 'string', 'max:25', Rule::unique('uom', 'uom_name')->ignore($this->uom_name, 'uom_name')],
            'uom_coretax'   => ['required', 'string', 'max:50'],
            'is_active'     => ['nullable', 'boolean'],
            'updated_by'    => ['required', 'string', 'max:100'],
            'reason'        => ['required', 'string', 'max:255'],
        ];
    }
}
