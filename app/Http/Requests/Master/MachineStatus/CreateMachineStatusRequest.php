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
            // Define validation rules here
        ];
    }
}
