<?php

namespace App\Http\Requests\Master\Workcenter;

use App\Http\Requests\BaseApiRequest;

class CreateWorkcenterRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workcenter_code'        => ['required', 'string', 'max:5', 'unique:workcenter,workcenter_code'],
            'workcenter_name'        => ['required', 'string', 'max:100', 'unique:workcenter,workcenter_name'],
            'workcenter_description' => ['nullable', 'string', 'max:100'],
            'default_warehouse'      => ['required', 'integer', 'exists:warehouse,warehouse_id'],
            'production_type'        => ['required', 'in:ML,PL'],
            'production_center'      => ['required', 'string', 'max:100'],
            'subprocess_level'       => ['nullable', 'integer'],
            'is_active'              => ['nullable', 'boolean'],
            'created_by'             => ['required', 'string', 'max:100']
        ];
    }
}
