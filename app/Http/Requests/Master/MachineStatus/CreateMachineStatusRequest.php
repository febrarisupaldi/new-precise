<?php

namespace App\Http\Requests\Master\MachineStatus;

use App\Http\Requests\BaseApiRequest;

class CreateMachineStatusRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_code'=> ['required', 'string', 'unique:machine_status,status_code'],
            'status_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'created_by' => ['required', 'string']
        ];
    }
}
