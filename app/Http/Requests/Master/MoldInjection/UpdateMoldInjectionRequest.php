<?php

namespace App\Http\Requests\Master\MoldInjection;

use App\Http\Requests\BaseApiRequest;

class UpdateMoldInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
