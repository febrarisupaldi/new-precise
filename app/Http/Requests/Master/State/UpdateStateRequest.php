<?php

namespace App\Http\Requests\Master\State;

use App\Http\Requests\BaseApiRequest;

class UpdateStateRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'state_code'   => ['required', 'string', 'max:10', "unique:state,state_code,{$id},state_id"],
            'state_name'   => ['required', 'string', 'max:255'],
            'country_id'   => ['required', 'integer', 'exists:country,country_id'],
            'updated_by'   => ['required', 'string', 'max:255'],
        ];
    }
}
