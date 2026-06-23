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
            // Define validation rules here
        ];
    }
}
