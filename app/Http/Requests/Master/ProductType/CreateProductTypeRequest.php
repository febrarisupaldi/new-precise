<?php

namespace App\Http\Requests\Master\ProductType;

use App\Http\Requests\BaseApiRequest;

class CreateProductTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_type_code' => ['required', 'string', 'max:1', 'unique:product_type,product_type_code'],
            'product_type_name' => ['required', 'string', 'max:255'],
            'created_by'        => ['required', 'string', 'max:100']
        ];
    }
}
