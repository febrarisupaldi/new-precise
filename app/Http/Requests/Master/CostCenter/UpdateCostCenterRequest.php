<?php

namespace App\Http\Requests\Master\CostCenter;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateCostCenterRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cost_center_code' => [
                'required',
                'string',
                Rule::unique("cost_center")
                    ->ignore($this->cost_center_code, 'cost_center_code')
            ],
            'cost_center_name' => ['required', 'string'],
            'updated_by' => ['required', 'string', 'max:100'],
            'reason'     => ['required', 'string'],
        ];
    }
}
