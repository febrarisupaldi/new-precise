<?php

namespace App\Http\Requests\Master\CustomerAddress;

use App\Http\Requests\BaseApiRequest;

class UpdateCustomerAddressRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'customer_id'       => ['required','exists:customer,customer_id'],
            'address_type_id'   => ['required','exists:address_type,address_type_id'],
            'is_default'        => ['required','boolean'],
            'address'           => ['required','string'],
            'subdistrict'       => ['nullable','string'],
            'district'          => ['nullable','string'],
            'city_id'           => ['nullable','exists:city,city_id'],
            'zipcode'           => ['nullable','string'],
            'phone_number'      => ['nullable','string'],
            'fax_number'        => ['nullable','string'],
            'email'             => ['nullable','email'],
            'website'           => ['nullable','string'],
            'off_hour'          => ['nullable','string'],
            'contact_person'    => ['nullable','string'],
            'updated_by'        => ['required', 'string'],
            'reason'            => ['required', 'string'],
        ];
    }
}
