<?php

namespace App\Http\Requests\Master\Country;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateCountryRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_code' => ['required', 'string', 'max:15', Rule::unique('country')->ignore($this->country_code, 'country_code')],
            'country_name' => ['required', 'string', 'max:50', Rule::unique('country')->ignore($this->country_name, 'country_name')],
            'updated_by'   => ['required', 'string', 'max:100'],
            'reason'       => ['required', 'string'],
        ];
    }
}
