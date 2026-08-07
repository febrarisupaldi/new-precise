<?php

namespace App\Http\Requests\Master\CoolingMethod;

use App\Http\Requests\BaseApiRequest;

class CreateCoolingMethodRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'created_by' => ['required','string', 'max:100']
        ];
    }
}
