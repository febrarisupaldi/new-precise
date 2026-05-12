<?php

namespace App\DTOs\Master\City;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCityDTO extends BaseDTO
{

    use AuditDTO;
    // Define properties here
    public string $city_code;
    public string $city_name;
    public string $state_id;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->city_code = $request->input('city_code');
        $dto->city_name = $request->input('city_name');
        $dto->state_id = $request->input('state_id');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason     = $request->input('reason');

        return $dto;
    }
}
