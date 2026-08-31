<?php

namespace App\Http\Requests\Master\RetailType;

use App\Http\Requests\BaseApiRequest;

class CreateRetailTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'retail_type_code' => ['required', 'string', 'unique:retail_type,retail_type_code'],
            'retail_type_description' => ['required', 'string', 'unique:retail_type,retail_type_description'],
            'GroupCodeOnProint' => ['required', 'string', 'unique:retail_type,GroupCodeOnProint'],
            'CreatedBy' => ['required', 'string', 'max:100']
        ];
    }
}
