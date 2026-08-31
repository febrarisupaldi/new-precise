<?php

namespace App\Http\Requests\Engineering\MoldPressingActivity;

use App\Http\Requests\BaseApiRequest;

class CreateMoldPressingActivityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mold_pressing_hd_id' => ['required', 'integer', 'exists:mold_pressing_hd,mold_pressing_hd_id'],
            'activity_date' => ['required', 'date_format:Y-m-d'],
            'mold_status_code' => ['required', 'string'],
            'location' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'created_by' => ['required', 'string']
        ];
    }
}
