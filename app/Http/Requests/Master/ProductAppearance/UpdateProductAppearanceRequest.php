<?php

namespace App\Http\Requests\Master\ProductAppearance;

use App\Http\Requests\BaseApiRequest;

class UpdateProductAppearanceRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'appearance_name' => ['nullable', 'string', 'max:100'],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
