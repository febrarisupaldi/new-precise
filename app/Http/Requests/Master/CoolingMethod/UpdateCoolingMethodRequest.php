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
            // Define validation rules here
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
