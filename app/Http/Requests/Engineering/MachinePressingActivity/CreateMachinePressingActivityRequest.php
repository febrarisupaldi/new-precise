<?php

namespace App\Http\Requests\Engineering\MachinePressingActivity;

use App\Http\Requests\BaseApiRequest;

class CreateMachinePressingActivityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'machine_pressing_id'   => ['required', 'exists:machine_pressing,machine_pressing_id'],
            'mold_pressing_hd_id'   => ['required'],
            'activity_date'         => ['required', 'date_format:Y-m-d H:i:s'],
            'trans_date'            => ['required', 'date_format:Y-m-d'],
            'machine_status_code'   => ['required', 'exists:machine_status,status_code'],
            'mold_status_code'      => ['required', 'exists:mold_status,status_code'],
            'setter_mold_nik'       => ['required', 'exists:users,user_id'],
            'shift'                 => ['required', 'numeric', 'between:1,3'],
            'activity_location'     => ['required'],
            'description'           => ['nullable'],
            'created_by'            => ['required']
        ];
    }
}
