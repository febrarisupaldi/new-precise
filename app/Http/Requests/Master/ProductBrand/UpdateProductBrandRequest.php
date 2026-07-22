<?php

namespace App\Http\Requests\Master\ProductBrand;

use App\Http\Requests\BaseApiRequest;

class UpdateProductBrandRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'product_brand_name' => ['required', 'string', 'max:100'],
            'is_active' => ['required', 'boolean'],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
