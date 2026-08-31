<?php

namespace App\Http\Requests\Engineering\MoldPressingActivity;

use App\Http\Requests\BaseApiRequest;

class UpdateMoldPressingActivityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
