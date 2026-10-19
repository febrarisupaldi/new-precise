<?php

namespace App\Http\Requests\Master\ProductLicenseType;

use App\Http\Requests\BaseApiRequest;

class CreateProductLicenseTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'license_type_name' => ['required', 'string', 'max:100', 'unique:product_license_type,license_type_name'],
            'created_by' => ['required', 'string', 'max:100']
        ];
    }
}
