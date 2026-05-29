<?php

namespace App\Http\Requests\Master\Vehicle;

use App\Http\Requests\BaseApiRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Define validation rules here
            "vehicle_model" => ['required', 'string'],
            "license_number" => ['required', 'string', Rule::unique('vehicles')->ignore($this->license_number, 'license_number')],
            "vehicle_description" => ['nullable', 'string'],
            "is_owned" => ['required', 'in:0,1'],
            "is_active" => ['nullable', 'in:0,1'],
            'updated_by' => ['required', 'string'],
            'reason'     => ['required', 'string'],
        ];
    }
}
