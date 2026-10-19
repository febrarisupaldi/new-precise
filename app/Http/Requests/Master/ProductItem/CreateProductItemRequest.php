<?php

namespace App\Http\Requests\Master\ProductItem;

use App\Http\Requests\BaseApiRequest;

class CreateProductItemRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_code'                 => ['required', 'string', 'max:25', 'unique:product_item,item_code'],
            'item_name'                 => ['required', 'string', 'max:100'],
            'item_name_en'              => ['nullable', 'string', 'max:100'],
            'item_alias'                => ['nullable', 'string', 'max:50'],
            'mold_code'                 => ['nullable', 'string', 'max:100'],
            'kind_code'                 => ['required', 'exists:product_kind,product_kind_code'],
            'series_id'                 => ['required', 'exists:product_series,series_id'],
            'brand_id'                  => ['nullable', 'exists:product_brand,product_brand_id'],
            'is_set'                    => ['nullable', 'boolean'],
            'is_active_sell'            => ['nullable', 'boolean'],
            'is_active_production'      => ['nullable', 'boolean'],
            'item_weight'               => ['nullable', 'numeric'],
            'item_depth'                => ['nullable', 'numeric'],
            'item_width'                => ['nullable', 'numeric'],
            'item_height'               => ['nullable', 'numeric'],
            'etching_text'              => ['nullable', 'string'],
            'inner_packing_length'      => ['nullable', 'numeric'],
            'inner_packing_width'       => ['nullable', 'numeric'],
            'inner_packing_height'      => ['nullable', 'numeric'],
            'inner_packing_qty'         => ['nullable', 'numeric'],
            'inner_net_weight_kg'       => ['nullable', 'numeric'],
            'inner_gross_weight_kg'     => ['nullable', 'numeric'],
            'master_packing_length'     => ['nullable', 'numeric'],
            'master_packing_width'      => ['nullable', 'numeric'],
            'master_packing_height'     => ['nullable', 'numeric'],
            'master_packing_qty'        => ['nullable', 'numeric'],
            'master_net_weight_kg'      => ['nullable', 'numeric'],
            'master_gross_weight_kg'    => ['nullable', 'numeric'],
            'created_by'                => ['required']
        ];
    }
}
