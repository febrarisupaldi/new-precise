<?php

namespace App\Http\Requests\Master\ProductDictionary;

use App\Http\Requests\BaseApiRequest;

class CreateProductDictionaryRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'created_by' => ['required','string', 'max:100']
        ];
    }
}
