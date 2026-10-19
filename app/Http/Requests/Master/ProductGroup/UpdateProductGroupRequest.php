<?php

namespace App\Http\Requests\Master\ProductGroup;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductGroupRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_group_code'        => ['required', Rule::unique('product_group')->ignore($this->product_group_code, 'product_group_code')],
            'product_group_name'        => ['required', Rule::unique('product_group')->ignore($this->product_group_name, 'product_group_name')],
            'product_type_id'           => ['required', 'exists:product_type,product_type_id'],
            'stock_coa_id'              => ['required', 'numeric'],
            'hpp_coa_id'                => ['required', 'numeric'],
            'sales_coa_id'              => ['required', 'numeric'],
            'sales_return_coa_id'       => ['required', 'numeric'],
            'discount_coa_id'           => ['required', 'numeric'],
            'unbilled_purchase_coa_id'  => ['required', 'numeric'],
            'unbilled_delivery_coa_id'  => ['required', 'numeric'],
            'updated_by'                => ['required', 'string', 'max:100'],
            'reason'                    => ['required', 'string'],
        ];
    }
}
