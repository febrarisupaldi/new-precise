<?php

namespace App\Http\Requests\Master\Driver;

use App\Http\Requests\BaseApiRequest;

class CreateDriverRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'driver_nik' => ['required', 'exists:employee,employee_nik'],
            'created_by' => ['required', 'string', 'max:100']
        ];
    }
}
