<?php

namespace App\Http\Requests\Master\City;

use App\Http\Requests\BaseApiRequest;

class CreateCityRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "city_code"   => ["required", "string", "max:15", "unique:city,city_code"],
            "city_name"   => ["required", "string", "max:50"],
            "state_id"    => ["required", "integer", "exists:state,state_id"],
            "created_by"  => ["required", "string", "max:100"]
        ];
    }
}
