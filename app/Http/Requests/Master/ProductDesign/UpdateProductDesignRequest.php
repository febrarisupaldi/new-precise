<?php

namespace App\Http\Requests\Master\ProductDesign;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductDesignRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'design_code'           => ['required', 'string', 'max:25', Rule::unique('product_design')->ignore($this->design_code, 'design_code')],
            'design_name'           => ['required', 'string', 'max:50', Rule::unique('product_design')->ignore($this->design_name, 'design_name')],
            'design_description'    => ['nullable', 'string', 'max:100'],
            'appearance_id'         => ['nullable', 'unique:product_appearance,appearance_id'],
            'license_type_id'       => ['nullable', 'unique:product_license_type,license_type_id'],
            'color_type_id'         => ['nullable', 'unique:color_type,color_type_id'],
            'polos_printing'        => ['nullable', 'string', 'in:Polos,Printing'],
            'color_type'            => ['nullable', 'string', 'max:50'],
            'color_group'           => ['nullable', 'string', 'max:50'],
            'order_type'            => ['nullable', 'string', 'max:50'],
            'material_group'        => ['nullable', 'string', 'max:100'],
            'is_active_sell'        => ['sometimes', 'required', 'boolean'],
            'is_active_production'  => ['sometimes', 'required', 'boolean'],
            'is_active'             => ['sometimes', 'required', 'boolean'],
            'updated_by'            => ['required', 'string', 'max:100'],
            'reason'                => ['required', 'string'],
        ];
    }
}
