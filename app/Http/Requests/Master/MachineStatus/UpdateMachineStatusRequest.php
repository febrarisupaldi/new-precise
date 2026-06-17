<?php

namespace App\Http\Requests\Master\MachineStatus;

use App\Http\Requests\BaseApiRequest;

class UpdateMachineStatusRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_code'=> ['required', 'string'],
            'status_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
