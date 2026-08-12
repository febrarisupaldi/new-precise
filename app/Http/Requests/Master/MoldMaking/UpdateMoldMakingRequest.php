<?php

namespace App\Http\Requests\Master\MoldMaking;

use App\Http\Requests\BaseApiRequest;

class UpdateMoldMakingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estimation_number' => ['required', 'string', 'max:255'],
            'updated_by'        => ['required', 'string', 'max:100'],
            'reason'            => ['required', 'string'],
        ];
    }
}
