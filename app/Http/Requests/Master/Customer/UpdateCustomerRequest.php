<?php

namespace App\Http\Requests\Master\Customer;

use App\Http\Requests\BaseApiRequest;

class UpdateCustomerRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
