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
            'workcenter_code'   => ['required', 'unique:workcenter,workcenter_code'],
            'workcenter_name'   => ['required'],
            'workcenter_desc'   => ['nullable'],
            'default_warehouse' => ['required', 'exists:warehouse,warehouse_id'],
            'created_by'        => ['required']
        ];
    }
}
