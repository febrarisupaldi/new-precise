<?php

namespace App\Http\Requests\Master\ProductAppearance;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductAppearanceRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appearance_name'   => [
                'required',
                'string',
                'max:100',
                Rule::unique('product_appearance')->ignore($this->appearance_name, 'appearance_name')
            ],
            'updated_by'        => ['required', 'string', 'max:100'],
            'reason'            => ['required', 'string'],
        ];
    }
}
