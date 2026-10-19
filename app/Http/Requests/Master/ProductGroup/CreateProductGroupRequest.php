<?php

namespace App\Http\Requests\Master\ProductGroup;

use App\Http\Requests\BaseApiRequest;

class CreateProductGroupRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_group_code'        => ['required', 'string', 'max:15', 'unique:product_group,product_group_code'],
            'product_group_name'        => ['required', 'string', 'max:100', 'unique:product_group,product_group_name'],
            'product_type_id'           => ['required', 'exists:product_type,product_type_id'],
            'stock_coa_id'              => ['nullable', 'numeric'],
            'hpp_coa_id'                => ['nullable', 'numeric'],
            'sales_coa_id'              => ['nullable', 'numeric'],
            'sales_return_coa_id'       => ['nullable', 'numeric'],
            'discount_coa_id'           => ['nullable', 'numeric'],
            'unbilled_purchase_coa_id'  => ['nullable', 'numeric'],
            'unbilled_delivery_coa_id'  => ['nullable'],
            'created_by'                => ['required', 'string', 'max:100']
        ];
    }
}
