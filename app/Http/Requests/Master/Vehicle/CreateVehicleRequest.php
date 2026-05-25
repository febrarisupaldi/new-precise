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
            "vehicle_model" => "required|string|max:255",
            "license_number" => "required|string|max:255|unique:vehicles,license_number",
            "vehicle_description" => "nullable|string",
            "is_owned" => "required|in:0,1",
            "is_active" => "nullable|in:0,1",
            "created_by" => "required",
        ];
    }
}
