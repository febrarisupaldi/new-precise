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
            'status_code'           => ['required', 'string', 'unique:machine_status,status_code', 'max:1'],
            'status_description'    => ['nullable', 'string', 'max:100'],
            'is_active'             => ['nullable', 'boolean'],
            'created_by'            => ['required', 'string', 'max:100']
        ];
    }
}
