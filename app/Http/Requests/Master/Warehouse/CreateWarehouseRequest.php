<?php

namespace App\Http\Requests\Master\Warehouse\Warehouse;

use App\Http\Requests\BaseApiRequest;

class CreateWarehouseRequest extends BaseApiRequest
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
