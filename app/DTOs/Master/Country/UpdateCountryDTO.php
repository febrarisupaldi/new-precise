<?php

namespace App\DTOs\Master\Country;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateCountryDTO extends BaseDTO
{
    public string $country_code;
    public string $country_name;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->country_code = $request->input('country_code');
        $dto->country_name = $request->input('country_name');
        $dto->created_by   = $request->input('created_by');
        return $dto;
    }
}
