<?php

namespace App\Http\Requests\Master\ColorType;

use App\Http\Requests\BaseApiRequest;

class CreateColorTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'color_type_code' => ['required', 'unique:color_type,color_type_code'],
            'color_type_name' => ['required','string'],
            'created_by'      => ['required','string'] 
        ];
    }
}
