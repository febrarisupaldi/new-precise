<?php

namespace App\Http\Requests\Master\MoldInjection;

use App\Http\Requests\BaseApiRequest;

class CreateMoldInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mold_number'                                     => ['required', 'string', 'max:25', 'unique:mold_injection_hd,mold_number'],
            'mmit_code_dont_use'                              => ['nullable', 'string', 'max:25'],
            'mold_name'                                       => ['nullable', 'string', 'max:100'],
            'is_family_mold'                                  => ['required', 'boolean'],
            'status_code'                                     => ['required', 'exists:mold_status,status_code'],
            'customer_id'                                     => ['nullable', 'exists:customer,customer_id'],
            'remake_from'                                     => ['nullable', 'integer'],
            'production_date'                                 => ['nullable', 'date_format:Y-m-d'],
            'tonnage_std'                                     => ['nullable', 'integer'],
            'tonnage_min'                                     => ['nullable', 'integer'],
            'tonnage_max'                                     => ['nullable', 'integer'],
            'steel_type_id'                                   => ['nullable', 'exists:steel_type,steel_type_id'],
            'mold_making_id'                                  => ['nullable', 'exists:mold_making,mold_making_id'],
            'mold_maker'                                      => ['nullable', 'string', 'max:100'],
            'cooling_method_id'                               => ['nullable', 'exists:cooling_method,cooling_method_id'],
            'mold_description'                                => ['nullable', 'string', 'max:255'],
            'length'                                          => ['nullable', 'integer'],
            'width'                                           => ['nullable', 'integer'],
            'height'                                          => ['nullable', 'integer'],
            'dimension_uom'                                   => ['nullable', 'exists:uom,uom_code'],
            'plate_size_length'                               => ['nullable', 'integer'],
            'plate_size_width'                                => ['nullable', 'integer'],
            'plate_size_uom'                                  => ['nullable', 'exists:uom,uom_code'],
            'created_by'                                      => ['required'],
            'details'                                         => ['sometimes', 'array'],
            'details.*.mold_group'                            => ['nullable', 'string', 'max:25'],
            'details.*.item_id'                               => ['nullable', 'exists:product_item,item_id'],
            'details.*.item_code'                             => ['required', 'exists:product_item,item_code'],
            'details.*.item_description'                      => ['nullable', 'string', 'max:100'],
            'details.*.created_by'                            => ['required', 'string', 'max:100'],
            'details.*.cavities'                              => ['sometimes', 'array'],
            'details.*.cavities.*.cavity_number'              => ['required', 'integer'],
            'details.*.cavities.*.product_weight'             => ['nullable', 'decimal:0,2'],
            'details.*.cavities.*.qty_set'                    => ['required', 'integer'],
            'details.*.cavities.*.cavity_active_per_set'      => ['required', 'integer'],
            'details.*.cavities.*.cavity_total'               => ['required', 'integer'],
            'details.*.cavities.*.product_weight_uom'         => ['nullable', 'exists:uom,uom_code'],
            'details.*.cavities.*.is_active'                  => ['nullable', 'boolean'],
            'details.*.cavities.*.created_by'                 => ['required', 'string', 'max:50']
        ];
    }
}
