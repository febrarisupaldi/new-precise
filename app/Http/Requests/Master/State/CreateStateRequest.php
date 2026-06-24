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
            'state_code'   => ['required', 'string', 'max:15', 'unique:state,state_code'],
            'state_name'   => ['required', 'string', 'max:50'],
            'country_id'   => ['required', 'integer', 'exists:country,country_id'],
            'created_by'   => ['required', 'string', 'max:100']
        ];
    }
}
