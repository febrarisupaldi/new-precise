<?php

namespace App\Http\Requests\SalesMarketing\SalesOrder\SalesOrder;

use App\Http\Requests\BaseApiRequest;

class CreateSalesOrderRequest extends BaseApiRequest
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
