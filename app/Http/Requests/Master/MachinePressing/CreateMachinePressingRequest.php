<?php

namespace App\Http\Requests\Master\MachinePressing;

use App\Http\Requests\BaseApiRequest;

class CreateMachinePressingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'machine_code'          => ['required', 'string', 'max:10', 'unique:machine_pressing,machine_code'],
            'old_machine_code'      => ['nullable', 'string', 'max:10'],
            'machine_location'      => ['required', 'string', 'max:25'],
            'line_code'             => ['required', 'string', 'max:1'],
            'line_number'           => ['nullable', 'integer'],
            'tonnage'               => ['required', 'integer'],
            'serial_number'         => ['required', 'string', 'max:25'],
            'production_year'       => ['required', 'date_format:Y'],
            'brand'                 => ['required', 'string'],
            'motor_power'           => ['required', 'decimal:5,2'],
            'heater_power'          => ['required', 'decimal:5,2'],
            'can_plain'             => ['nullable', 'boolean'],
            'can_print'             => ['nullable', 'boolean'],
            'can_mug'               => ['nullable', 'boolean'],
            'can_bico_lg'           => ['nullable', 'boolean'],
            'can_bico_material'     => ['nullable', 'boolean'],
            'priority_rank'         => ['required', 'integer'],
            'machine_status_code'   => ['required', 'string', 'exists:machine_status,status_code', 'max:1'],
            'created_by'            => ['required', 'string'],
        ];
    }
}
