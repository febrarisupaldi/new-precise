<?php

namespace App\Http\Requests\Master\Warehouse\Warehouse;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_code' => ['required', 'string', Rule::unique('warehouse')->ignore($this->warehouse_code, 'warehouse_code')],
            'warehouse_name' => ['required', 'string'],
            'warehouse_alias' => ['nullable', 'string'],
            'warehouse_group_code' => ['required', 'string', 'exists:warehouse_group,warehouse_group_code'],
            'is_active' => ['nullable', 'boolean'],
            'warehouse_pic_1' => ['nullable', 'integer', 'exists:users,user_id'],
            'warehouse_pic_2' => ['nullable', 'integer', 'exists:users,user_id'],
            'warehouse_approver' => ['nullable', 'integer', 'exists:users,user_id'],
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string'],
        ];
    }
}
