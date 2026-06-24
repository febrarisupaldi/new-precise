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
            'color_type_code' => ['required','max:50', 'unique:color_type,color_type_code'],
            'color_type_name' => ['required','max:50', 'string'],
            'created_by'      => ['required','max:100', 'string'] 
        ];
    }
}
