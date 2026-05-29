<?php

namespace App\Http\Requests\Master\Product\Product;

use App\Http\Requests\BaseApiRequest;

class CreateProductRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
