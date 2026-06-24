<?php

namespace App\Http\Requests\Master\Vehicle;

use App\Http\Requests\BaseApiRequest;

class CreateVehicleRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_model'       => ['required', 'string', 'max:100'],
            'license_number'      => ['required', 'string', 'max:25', 'unique:vehicles,license_number'],
            'vehicle_description' => ['nullable', 'string', 'max:255'],
            'is_owned'            => ['nullable', 'boolean'],
            'is_active'           => ['nullable', 'boolean'],
            'created_by'          => ['required', 'string', 'max:100'],
        ];
    }
}
