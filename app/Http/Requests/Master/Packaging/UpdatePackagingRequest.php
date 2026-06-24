<?php

namespace App\Http\Requests\Master\Packaging;

use App\Http\Requests\BaseApiRequest;

class UpdatePackagingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'packaging_alias'           => ['required', 'string', 'max:100'],
            'inner_length'              => ['nullable', 'numeric'],
            'inner_width'               => ['nullable', 'numeric'],
            'inner_height'              => ['nullable', 'numeric'],
            'outer_length'              => ['nullable', 'numeric'],
            'outer_width'               => ['nullable', 'numeric'],
            'outer_height'              => ['nullable','numeric'],
            'dimension_uom_code'        => ['required', 'exists:uom,uom_code'],
            'weight'                    => ['nullable','numeric'],
            'weight_uom_code'           => ['nullable', 'exists:uom,uom_code'],
            'packaging_spec'            => ['nullable','string', 'max:100'],
            'max_stack'                 => ['nullable','numeric'],
            'is_active'                 => ['nullable', 'boolean'],
            'updated_by'                => ['required', 'string', 'max:255'],
            'reason'                    => ['required', 'string', 'max:255'],
            'details'                   => ['nullable','array'],
            'details.*.packaging_dt_id' => ['nullable', 'exists:packaging_dt,packaging_dt_id'],
            'details.*.packaging_id'    => ['nullable', 'exists:packaging_hd,packaging_id'],
            'details.*.product_id'      => ['nullable', 'exists:product,product_id'],
            'details.*.item_id'         => ['nullable', 'exists:product_item,item_id'],
            'details.*.item_code'       => ['required'],
            'details.*.product_qty'     => ['required', 'numeric'],
            'details.*.priority'        => ['required', 'numeric'],
            'details.*.usage_per_unit'  => ['nullable', 'numeric'],
            'details.*.updated_by'      => ['required', 'string', 'max:100']
        ];
    }
}
