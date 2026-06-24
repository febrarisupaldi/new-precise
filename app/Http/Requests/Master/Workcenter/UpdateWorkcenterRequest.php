<?php

namespace App\Http\Requests\Master\Workcenter;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateWorkcenterRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'workcenter_code'        => ['required', 'string','max:5', Rule::unique('workcenter')->ignore($this->workcenter_code, 'workcenter_code')],
            'workcenter_name'        => ['required', 'string','max:100', Rule::unique('workcenter')->ignore($this->workcenter_name, 'workcenter_name')],
            'workcenter_description' => ['nullable', 'string','max:100'],
            'default_warehouse'      => ['required', 'integer','exists:warehouse,warehouse_id'],
            'production_type'        => ['required', 'in:ML,PL'],
            'production_center'      => ['required', 'string', 'max:100'],
            'subprocess_level'       => ['nullable', 'integer'],
            'is_active'              => ['nullable', 'boolean'],
            'updated_by'             => ['required', 'string','max:100'],
            'reason'                 => ['required', 'string','max:255'],
        ];
    }
}
