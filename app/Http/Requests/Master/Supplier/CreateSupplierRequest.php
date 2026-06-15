<?php

namespace App\Http\Requests\Master\Supplier;

use App\Http\Requests\BaseApiRequest;

class CreateSupplierRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
        ];
    }
}
