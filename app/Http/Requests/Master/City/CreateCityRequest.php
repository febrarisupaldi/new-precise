<?php

namespace App\Http\Requests\Master\City;

use App\Http\Requests\BaseApiRequest;

class CreateCityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
