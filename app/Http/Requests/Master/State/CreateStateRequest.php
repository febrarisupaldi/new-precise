<?php

namespace App\Http\Requests\Master\State;

use App\Http\Requests\BaseApiRequest;

class CreateStateRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state_code'   => ['required', 'string', 'max:10', 'unique:state,state_code'],
            'state_name'   => ['required', 'string', 'max:255'],
            'country_id'   => ['required', 'integer', 'exists:country,country_id'],
            'created_by'   => ['required', 'string', 'max:255'],
            'updated_by'   => ['required', 'string', 'max:255'],
        ];
    }
}
