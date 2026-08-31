<?php

namespace App\Http\Requests\Master\CostCenter;

use App\Http\Requests\BaseApiRequest;

class CreateCostCenterRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cost_center_code' => ['required', 'string', 'unique:cost_center,cost_center_code'],
            'cost_center_name' => ['required', 'string'],
            'created_by' => ['required', 'string', 'max:100']
        ];
    }
}
