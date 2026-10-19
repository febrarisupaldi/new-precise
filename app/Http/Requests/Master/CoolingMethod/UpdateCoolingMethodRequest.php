<?php

namespace App\Http\Requests\Master\CoolingMethod;

use App\Http\Requests\BaseApiRequest;

class UpdateCoolingMethodRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cooling_method_name'           => ['required', 'string', 'max:50'],
            'cooling_method_description'    => ['nullable', 'string', 'max:100'],
            'is_active'                     => ['nullable', 'boolean'],
            'updated_by'                    => ['required', 'string', 'max:100'],
            'reason'                        => ['required', 'string'],
        ];
    }
}
