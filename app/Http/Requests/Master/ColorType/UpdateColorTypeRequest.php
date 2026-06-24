<?php

namespace App\Http\Requests\Master\ColorType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateColorTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'color_type_code' => ['required', 'string', 'max:50', Rule::unique('color_type', 'color_type_code')->ignore($this->color_type_code, 'color_type_code')],
            'color_type_name' => ['required', 'string', 'max:50'],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
