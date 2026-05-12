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
            'country_code' => ['required', 'string', 'max:10', Rule::unique('country')->ignore($this->country_code, 'country_code')],
            'country_name' => ['required', 'string', 'max:255'],
            'updated_by'   => ['required', 'string', 'max:255'],
            'reason'       => ['required', 'string', 'max:255'],
        ];
    }
}
