<?php

namespace App\Http\Requests\Master\ProductAppearance;

use App\Http\Requests\BaseApiRequest;

class CreateProductAppearanceRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appearance_name' => ['nullable', 'string', 'max:100'],
            'created_by' => ['required', 'string', 'max:100']
        ];
    }
}
