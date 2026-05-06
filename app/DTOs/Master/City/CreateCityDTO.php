<?php

namespace App\DTOs\Master\City;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCityDTO extends BaseDTO
{
    public string $city_code;
    public string $city_name;
    public string $state_id;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->city_code = $request->input('city_code');
        $dto->city_name = $request->input('city_name');
        $dto->state_id = $request->input('state_id');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
