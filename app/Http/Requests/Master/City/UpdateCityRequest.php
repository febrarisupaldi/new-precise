<?php

namespace App\Http\Requests\Master\City;

use App\Http\Requests\BaseApiRequest;

class UpdateCityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string', 'max:255'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
