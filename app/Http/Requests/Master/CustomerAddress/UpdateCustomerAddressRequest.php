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
            'subdistrict'       => ['nullable','string', 'max:255'],
            'district'          => ['nullable','string', 'max:255'],
            'city_id'           => ['nullable','exists:city,city_id'],
            'zipcode'           => ['nullable','string', 'max:5'],
            'phone_number'      => ['nullable','string', 'max:255'],
            'fax_number'        => ['nullable','string', 'max:255'],
            'email'             => ['nullable','email', 'max:100'],
            'website'           => ['nullable','string', 'max:100'],
            'off_hour'          => ['nullable','string', 'max:60'],
            'contact_person'    => ['nullable','string', 'max:100'],
            'updated_by'        => ['required', 'string'],
            'reason'            => ['required', 'string'],
        ];
    }
}
