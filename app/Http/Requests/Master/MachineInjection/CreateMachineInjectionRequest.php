<?php

namespace App\Http\Requests\Master\MachineInjection;

use App\Http\Requests\BaseApiRequest;

class CreateMachineInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'machine_code'          => ['required','string', 'max:10', 'unique:machine_injection,machine_code'],
            'old_machine_code'      => ['nullable','string', 'max:10'],
            'line_code'             => ['required','string','max:1'],
            'line_number'           => ['nullable','integer'],
            'tonnage'               => ['required','integer'],
            'serial_number'         => ['nullable','string'],
            'production_year'       => ['nullable','integer','date_format:Y'],
            'brand'                 => ['required','string'],
            'motor_power'           => ['nullable','decimal:5,2'],
            'heater_power'          => ['nullable','decimal:5,2'],
            'machine_status_code'   => ['required','exists:machine_status,status_code', 'max:1'],
            'created_by'            => ['required','string', 'max:100'],
        ];
    }
}
