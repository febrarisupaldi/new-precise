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
            'vehicle_model'       => ['required', 'string', 'max:100'],
            'license_number'      => ['required', 'string', 'max:25', Rule::unique('vehicles')->ignore($this->license_number, 'license_number')],
            'vehicle_description' => ['nullable', 'string', 'max:255'],
            'is_owned'            => ['nullable', 'boolean'],
            'is_active'           => ['nullable', 'boolean'],
            'updated_by'          => ['required', 'string', 'max:100'],
            'reason'              => ['required', 'string'],
        ];
    }
}
