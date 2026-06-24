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
            'status_description'    => ['nullable', 'string', 'max:100'],
            'is_active'             => ['nullable', 'boolean'],
            'updated_by'            => ['required', 'string', 'max:100'],
            'reason'                => ['required', 'string', 'max:255'],
        ];
    }
}
