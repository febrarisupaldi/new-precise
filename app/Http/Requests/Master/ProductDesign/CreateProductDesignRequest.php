<?php

namespace App\Http\Requests\Master\ProductDesign;

use App\Http\Requests\BaseApiRequest;

class CreateProductDesignRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'created_by' => ['required','string', 'max:100']
        ];
    }
}
