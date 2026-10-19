<?php

namespace App\Http\Requests\Master\ProductBrand;

use App\Http\Requests\BaseApiRequest;

class CreateProductBrandRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_brand_name'    => ['required', 'string', 'max:100', 'unique:product_brand,product_brand_name'],
            'is_active'             => ['required', 'boolean'],
            'created_by'            => ['required', 'string', 'max:100']
        ];
    }
}
