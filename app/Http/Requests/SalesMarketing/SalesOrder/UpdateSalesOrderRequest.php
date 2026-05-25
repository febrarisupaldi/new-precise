<?php

namespace App\Http\Requests\SalesMarketing\SalesOrder\SalesOrder;

use App\Http\Requests\BaseApiRequest;

class UpdateSalesOrderRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            'updated_by' => ['required', 'string', 'max:255'],
            'reason'     => ['required', 'string', 'max:255'],
        ];
    }
}
