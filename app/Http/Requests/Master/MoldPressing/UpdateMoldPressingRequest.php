<?php

namespace App\Http\Requests\Master\MoldPressing;

use App\Http\Requests\BaseApiRequest;

class UpdateMoldPressingRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mold_number'               => ['required', 'string', 'max:25', 'unique:mold_injection_hd,mold_number'],
            'mold_code'                 => ['required', 'string', 'max:25'],
            'mold_group'                => ['required', 'string', 'max:25'],
            'mold_rack'                 => ['nullable', 'string', 'max:25'],
            'mold_location'             => ['nullable', 'string', 'max:100'],
            'item_code'                 => ['nullable', 'exists:product_item,item_code'],
            'default_tonnage'           => ['required', 'integer'],
            'mold_description'          => ['nullable', 'string'],
            'mold_status_code'          => ['required', 'exists:mold_status,status_code'],
            'mold_parent_id'            => ['nullable', 'exists:mold_injection_hd,mold_injection_hd_id'],
            'production_date'           => ['nullable', 'date_format:Y-m-d'],
            'steel_type_id'             => ['nullable', 'exists:steel_type,steel_type_id'],
            'mold_making_id'            => ['nullable', 'exists:mold_making,mold_making_id'],
            'mold_maker'                => ['nullable', 'string', 'max:100'],
            'updated_by'                => ['required', 'string', 'max:100'],
            'reason'                    => ['required', 'string'],
            'details'                   => ['sometimes', 'array'],
            'details.*.mold_group'      => ['nullable', 'string', 'max:25'],
            'details.*.item_code'       => ['required', 'exists:product_item,item_code'],
            'details.*.item_description' => ['nullable', 'string', 'max:100'],
            'details.*.updated_by'      => ['required', 'string', 'max:100'],
        ];
    }
}
