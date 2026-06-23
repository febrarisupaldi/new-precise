<?php

namespace App\Http\Requests\Master\MachinePressing;

use App\Http\Requests\BaseApiRequest;

class UpdateMachinePressingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
