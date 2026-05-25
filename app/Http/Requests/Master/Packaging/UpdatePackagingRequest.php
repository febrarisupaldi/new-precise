<?php

namespace App\Http\Requests\Master\Packaging\Packaging;

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
            // Define validation rules here
            'packaging_alias'       => ["required", "string"],
            'inner_length'          => ['nullable','numeric'],
            'inner_width'           => ['nullable','numeric'],
            'inner_height'          => ['nullable','numeric'],
            'outer_length'          => ['nullable','numeric'],
            'outer_width'           => ['nullable','numeric'],
            'outer_height'          => ['nullable','numeric'],
            'dimension_uom_code'    => ['required', 'exists:uom,uom_code'],
            'weight'                => ['nullable','numeric'],
            'weight_uom_code'       => ['nullable', 'exists:uom,uom_code'],
            'packaging_spec'        => ['nullable','string'],
            'max_stack'             => ['nullable','numeric'],
            'is_active'             => ['nullable'],
            'updated_by'            => ['required', 'string', 'max:255'],
            'reason'                => ['required', 'string', 'max:255'],
            'details'               => ['nullable','array'],
            'details.*.packaging_dt_id' => ['nullable', 'exists:product_item,product_item_id'],
            'details.*.packaging_id' => ['nullable', 'exists:product,product_id'],
            'details.*.product_id'  => ['nullable', 'exists:product,product_id'],
            'details.*.item_id'     => ['nullable', 'exists:product_item,item_id'],
            'details.*.item_code'   => ['required'],
            'details.*.product_qty' => ['required', 'numeric'],
            'details.*.priority'    => ['required', 'numeric'],
            'details.*.usage_per_unit' => ['required', 'numeric'],
            'details.*.created_by'  => ['required']
        ];
    }
}
