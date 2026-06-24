<?php

namespace App\Http\Requests\Master\State;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateStateRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'state_code'   => ['required', 'string', 'max:15', Rule::unique('state')->ignore($this->state_code, 'state_code')],
            'state_name'   => ['required', 'string', 'max:50'],
            'country_id'   => ['required', 'integer', 'exists:country,country_id'],
            'updated_by'   => ['required', 'string', 'max:100'],
            'reason'       => ['required', 'string'],
        ];
    }
}
