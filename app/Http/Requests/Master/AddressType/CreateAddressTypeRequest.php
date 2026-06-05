<?php

namespace App\Http\Requests\Master\AddressType;

use App\Http\Requests\BaseApiRequest;

class CreateAddressTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'address_type_name'        => ['required', 'string', 'max:255', 'unique:address_type,address_type_name'],
            'address_type_description' => ['nullable', 'string'],
            'created_by'               => ['required', 'string', 'max:255'],
        ];
    }
}
