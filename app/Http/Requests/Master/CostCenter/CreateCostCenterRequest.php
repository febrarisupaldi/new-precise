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
            'cost_center_code'      => ['required', 'string', 'max:10', 'unique:cost_center,cost_center_code'],
            'cost_center_name'      => ['required', 'string', 'max:50'],
            'cost_center_alias'     => ['nullable', 'string', 'max:60'],
            'cc_group_code'         => ['nullable', 'string', 'max:3'],
            'cc_prod_center'        => ['nullable', 'string', 'max:3'],
            'cc_revenue_center'     => ['nullable', 'string', 'max:3'],
            'cc_profit_center'      => ['nullable', 'string', 'max:3'],
            'pr_group'              => ['nullable', 'string', 'max:15'],
            'fg_cost_center'        => ['nullable', 'string', 'max:1'],
            'fg_prod_center'        => ['nullable', 'string', 'max:1'],
            'fg_revenue_center'     => ['nullable', 'string', 'max:1'],
            'active_date'           => ['nullable', 'date_format:Y-m-d H:i:s'],
            'approved_by'           => ['nullable', 'string', 'max:15'],
            'created_by'            => ['required', 'string', 'max:100']
        ];
    }
}
