<?php

namespace App\Http\Requests\Master\ProductLicenseType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateProductLicenseTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'license_type_name' => ['required', 'string', 'max:100', Rule::unique('product_license_type')->ignore($this->product_license_type_id, 'license_type_name')],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
