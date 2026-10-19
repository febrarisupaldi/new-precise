<?php

namespace App\Http\Requests\Master\ProductVariant;

use App\Http\Requests\BaseApiRequest;

class CreateProductVariantRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_item_id'               => ['required', 'integer', 'exists:product_item,item_id'],
            'product_variant_code'          => ['required', 'string', 'max:20', 'unique:product_variant,product_variant_code'],
            'product_variant_name'          => ['required', 'string', 'max:100'],
            'product_variant_description'   => ['nullable', 'string', 'max:255'],
            'is_active'                     => ['required', 'boolean'],
            'created_by'                    => ['required', 'string', 'max:100']
        ];
    }
}
