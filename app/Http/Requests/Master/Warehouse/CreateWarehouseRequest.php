<?php

namespace App\Http\Requests\Master\Warehouse;

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
            'warehouse_code'       => ['required', 'string', 'max:12', 'unique:warehouse,warehouse_code'],
            'warehouse_name'       => ['required', 'string', 'max:100', 'unique:warehouse,warehouse_name'],
            'warehouse_alias'      => ['nullable', 'string', 'max:25', 'unique:warehouse,warehouse_alias'],
            'warehouse_group_code' => ['required', 'string', 'max:4', 'exists:warehouse_group,warehouse_group_code'],
            'is_active'            => ['nullable', 'boolean'],
            'warehouse_pic_1'      => ['nullable', 'integer', 'exists:users,user_id'],
            'warehouse_pic_2'      => ['nullable', 'integer', 'exists:users,user_id'],
            'warehouse_approver'   => ['nullable', 'integer', 'exists:users,user_id'],
            'created_by'           => ['required', 'string', 'max:100'],
        ];
    }
}
