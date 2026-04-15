<?php

namespace App\Http\Requests\Master\Country;

use App\Http\Requests\BaseApiRequest;

class CreateCountryRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_code' => ['required', 'string', 'max:10'],
            'country_name' => ['required', 'string', 'max:255'],
            'created_by'   => ['required', 'string', 'max:255'],
        ];
    }
}
