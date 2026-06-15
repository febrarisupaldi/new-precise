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
            'mold_number'                           => ['required', 'unique:mold_hd,mold_number'],
            'mold_name'                             => ['required', 'unique:mold_hd,mold_name'],
            'is_family_mold'                        => ['required', 'boolean'],
            'status_code'                           => ['required', 'exists:mold_status,status_code'],
            'customer_id'                           => ['nullable', 'exists:customer,customer_id'],
            'remake_from'                           => ['nullable', 'exists:mold_hd,mold_hd_id'],
            'production_date'                       => ['nullable', 'date_format:Y-m-d'],
            'tonnage_std'                           => ['nullable', 'numeric'],
            'tonnage_min'                           => ['nullable', 'numeric'],
            'tonnage_max'                           => ['nullable', 'numeric'],
            'steel_type_id'                         => ['nullable', 'exists:steel_type,steel_type_id'],
            'mold_making_id'                        => ['nullable', 'exists:mold_making,mlod_making_id'],
            'mold_maker'                            => ['nullable'],
            'cooling_method_id'                     => ['nullable', 'exists:cooling_method,cooling_method_id'],
            'length'                                => ['nullable', 'numeric'],
            'width'                                 => ['nullable', 'numeric'],
            'height'                                => ['nullable', 'numeric'],
            'dimension_uom'                         => ['nullable', 'exists:uom,uom_code'],
            'plate_size_length'                     => ['nullable', 'numeric'],
            'plate_size_width'                      => ['nullable', 'numeric'],
            'plate_size_uom'                        => ['nullable', 'exists:uom,uom_code'],
            'created_by'                            => ['required'],
            'details'                               => ['required','array'],
            'details.*.mold_group'                  => ['nullable'],
            'details.*.item_code'                   => ['required', 'exists:product_item,product_code'],
            'details.*.created_by'                  => ['required'],
            'details.*.desc'                        => ['nullable'],
            'details.*.cavity'                      => ['required','array'],
            'details.*.cavity.*.cavity_number'      => ['required'],
            'details.*.cavity.*.product_weight'     => ['required'],
            'details.*.cavity.*.product_weight_uom' => ['required', 'exists:uom,uom_code'],
            'details.*.cavity.*.is_active'          => ['required', 'boolean'],
            'details.*.cavity.*.created_by'         => ['required'],
        ];
    }
}
