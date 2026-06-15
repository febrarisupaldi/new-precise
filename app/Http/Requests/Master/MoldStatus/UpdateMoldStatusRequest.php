<?php

namespace App\Http\Requests\Master\MoldStatus;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateMoldStatusRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status_code' =>[
                'required','string',
                 Rule::unique('mold_status', 'status_code')->ignore($this->status_code, 'status_code')],
            'status_description' => ['required','string'],
            'is_active' => ['nullable','boolean'],
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string'],
        ];
    }
}
