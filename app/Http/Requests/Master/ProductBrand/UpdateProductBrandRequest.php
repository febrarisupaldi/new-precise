<?php

namespace App\Http\Requests\Master\ProductBrand;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductBrandRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_brand_name'    => [
                'required',
                'string',
                'max:100',
                Rule::unique('product_brand')->ignore($this->product_brand_name, 'product_brand_name')
            ],
            'is_active'             => ['required', 'boolean'],
            'updated_by'            => ['required', 'string', 'max:100'],
            'reason'                => ['required', 'string'],
        ];
    }
}
