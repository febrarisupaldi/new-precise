<?php

namespace App\Http\Requests\Master\City;

use App\Http\Requests\BaseApiRequest;

class UpdateCityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "city_code"   => ["required", "string", "max:10"],
            "city_name"   => ["required", "string", "max:255"],
            "state_id"    => ["required", "integer", "exists:state,state_id"],
            "updated_by"  => ["required", "string", "max:255"],
            "reason"      => ["required", "string"],
        ];
    }
}
