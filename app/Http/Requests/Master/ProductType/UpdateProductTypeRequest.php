<?php

namespace App\Http\Requests\Master\ProductType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_type_code' => [
                'required',
                'string',
                'max:1',
                Rule::unique('product_type')->ignore($this->product_type_code, 'product_type_code')
            ],
            'product_type_name' => ['required', 'string', 'max:255'],
            'updated_by'        => ['required', 'string', 'max:100'],
            'reason'            => ['required', 'string'],
        ];
    }
}
