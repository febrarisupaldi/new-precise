<?php

namespace App\Http\Requests\Master\MoldMaking;

use App\Http\Requests\BaseApiRequest;

class CreateMoldMakingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estimation_number' => ['required', 'string', 'max:255'],
            'created_by'        => ['required', 'string', 'max:100']
        ];
    }
}
