<?php

namespace App\Http\Requests\PPIC\MaterialUsage;

use App\Http\Requests\BaseApiRequest;

class CreateMaterialUsageRequest extends BaseApiRequest
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
