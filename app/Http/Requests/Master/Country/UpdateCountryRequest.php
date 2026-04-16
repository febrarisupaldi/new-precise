<?php

namespace App\Http\Requests\Master\Country;

use App\Http\Requests\BaseApiRequest;

class UpdateCountryRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $countryId = $this->route('id');

        return [
            'country_code' => ['required', 'string', 'max:10'],
            'country_name' => ['required', 'string', 'max:255'],
            'updated_by'   => ['required', 'string', 'max:255'],
            'reason'       => ['required', 'string', 'max:255'],
        ];
    }
}
