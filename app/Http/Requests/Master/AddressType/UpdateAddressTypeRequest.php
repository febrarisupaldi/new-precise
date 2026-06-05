<?php

namespace App\Http\Requests\Master\AddressType;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateAddressTypeRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'address_type_name'        => [
                'required',
                'string',
                'max:255',
                Rule::unique('address_type')->ignore($id, 'address_type_id')
            ],
            'address_type_description' => ['nullable', 'string'],
            'updated_by'               => ['required', 'string', 'max:255'],
            'reason'                   => ['required', 'string'],
        ];
    }
}
