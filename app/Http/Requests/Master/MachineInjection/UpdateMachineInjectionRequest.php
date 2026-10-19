<?php

namespace App\Http\Requests\Master\MachineInjection;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateMachineInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'machine_code'          => ['required', 'string', 'max:10', Rule::unique('machine_injection')->ignore($this->machine_code, 'machine_code')],
            'old_machine_code'      => ['nullable', 'string', 'max:10'],
            'line_code'             => ['required', 'string', 'max:1'],
            'line_number'           => ['required', 'integer'],
            'tonnage'               => ['required', 'integer'],
            'serial_number'         => ['nullable', 'string', 'max:25'],
            'production_year'       => ['nullable', 'integer', 'date_format:Y'],
            'brand'                 => ['required', 'string', 'max:25'],
            'motor_power'           => ['nullable', 'decimal:2'],
            'heater_power'          => ['nullable', 'decimal:2'],
            'machine_status_code'   => ['required', 'exists:machine_status,status_code'],
            'updated_by'            => ['required', 'string', 'max:100'],
            'reason'                => ['required', 'string'],
        ];
    }
}
