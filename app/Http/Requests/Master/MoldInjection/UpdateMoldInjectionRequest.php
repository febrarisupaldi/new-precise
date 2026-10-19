<?php

namespace App\Http\Requests\Master\MoldInjection;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateMoldInjectionRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mold_number'                                     => ['required', 'string', 'max:25', Rule::unique('mold_number')->ignore($this->mold_number, 'mold_number')],
            'mmit_code_dont_use'                              => ['nullable', 'string', 'max:25'],
            'mold_name'                                       => ['nullable', 'string', 'max:100'],
            'is_family_mold'                                  => ['required', 'boolean'],
            'status_code'                                     => ['required', 'exists:mold_status,status_code'],
            'customer_id'                                     => ['nullable', 'exists:customer,customer_id'],
            'remake_from'                                     => ['nullable', 'integer'],
            'production_date'                                 => ['nullable', 'date_format:Y-m-d'],
            'tonnage_std'                                     => ['nullable', 'numeric'],
            'tonnage_min'                                     => ['nullable', 'numeric'],
            'tonnage_max'                                     => ['nullable', 'numeric'],
            'steel_type_id'                                   => ['nullable', 'exists:steel_type,steel_type_id'],
            'mold_making_id'                                  => ['nullable', 'exists:mold_making,mold_making_id'],
            'mold_maker'                                      => ['nullable', 'string', 'max:100'],
            'cooling_method_id'                               => ['nullable', 'exists:cooling_method,cooling_method_id'],
            'mold_description'                                => ['nullable', 'string', 'max:255'],
            'length'                                          => ['nullable', 'numeric'],
            'width'                                           => ['nullable', 'numeric'],
            'height'                                          => ['nullable', 'numeric'],
            'dimension_uom'                                   => ['nullable', 'exists:uom,uom_code'],
            'plate_size_length'                               => ['nullable', 'numeric'],
            'plate_size_width'                                => ['nullable', 'numeric'],
            'plate_size_uom'                                  => ['nullable', 'exists:uom,uom_code'],
            'updated_by'                                      => ['required', 'string', 'max:100'],
            'reason'                                          => ['required', 'string'],
            'details'                                         => ['sometimes', 'array'],
            'details.*.mold_injection_dt_id'                  => ['sometimes', 'exists:mold_injection_dt,mold_injection_dt_id'],
            'details.*.mold_group'                            => ['nullable', 'string', 'max:25'],
            'details.*.item_code'                             => ['required', 'exists:product_item,item_code'],
            'details.*.item_description'                      => ['nullable', 'string', 'max:100'],
            'details.*.created_by'                            => ['sometimes', 'string', 'max:100'],
            'details.*.updated_by'                            => ['sometimes', 'string', 'max:100'],
            'details.*.cavities'                              => ['sometimes', 'array'],
            'details.*.cavities.*.mold_injection_cavity_id'   => ['sometimes', 'exists:mold_injection_cavity,mold_injection_cavity_id'],
            'details.*.cavities.*.cavity_number'              => ['required', 'string', 'max:10'],
            'details.*.cavities.*.qty_set'                    => ['nullable', 'integer'],
            'details.*.cavities.*.cavity_active_per_set'      => ['nullable', 'integer'],
            'details.*.cavities.*.cavity_total'               => ['nullable', 'integer'],
            'details.*.cavities.*.product_weight'             => ['nullable', 'decimal:2'],
            'details.*.cavities.*.product_weight_uom'         => ['nullable', 'exists:uom,uom_code'],
            'details.*.cavities.*.is_active'                  => ['nullable', 'boolean'],
            'details.*.cavities.*.created_by'                 => ['sometimes', 'string', 'max:100'],
            'details.*.cavities.*.updated_by'                 => ['sometimes', 'string', 'max:100'],
        ];
    }
}
