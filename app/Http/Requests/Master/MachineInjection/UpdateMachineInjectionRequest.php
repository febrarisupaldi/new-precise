<?php

namespace App\Http\Requests\Master\MachineInjection;

use App\Http\Requests\BaseApiRequest;

class UpdateMachineInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'machine_code' => ['required','string'],
            'old_machine_code' => ['nullable','string'],
            'line_code' => ['required','string'],
            'line_number' => ['nullable','string'],
            'tonnage' => ['required','integer'],
            'serial_number' => ['nullable','string'],
            'production_year' => ['nullable','integer'],
            'brand' => ['required','string'],
            'motor_power' => ['nullable','numeric'],
            'heater_power' => ['nullable','numeric'],
            'machine_status_code' => ['required','string'],
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
