<?php

namespace App\Http\Requests\Engineering\MachinePressingActivity;

use App\Http\Requests\BaseApiRequest;

class IndexMachinePressingActivityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date'              => ['required_with:shift,location', 'date_format:Y-m-d'],
            'shift'             => ['required_with:date,location', 'in:1,2,3'],
            'location'          => ['required_with:date,shift'],
            'machine_pressing'  => ['nullable', 'exists:machine_pressing,machine_pressing_id']
        ];
    }
}
