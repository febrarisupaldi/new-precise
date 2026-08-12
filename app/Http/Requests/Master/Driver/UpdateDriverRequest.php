<?php

namespace App\Http\Requests\Master\Driver;

use App\Http\Requests\BaseApiRequest;

class UpdateDriverRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active'  => ['required', 'boolean'],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
