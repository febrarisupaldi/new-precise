<?php

namespace App\Http\Requests\Master\MoldStatus;

use App\Http\Requests\BaseApiRequest;

class CreateMoldStatusRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_code' =>['required','string','unique:mold_status,status_code'],
            'status_description' => ['required','string'],
            'is_active' => ['nullable','boolean'],
            'created_by' => ['required','string'],
        ];
    }
}
