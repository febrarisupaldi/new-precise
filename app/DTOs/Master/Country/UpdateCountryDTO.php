<?php

namespace App\DTOs\Master\Country;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateCountryDTO extends BaseDTO
{
    public string $country_code;
    public string $country_name;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->country_code = $request->input('country_code');
        $dto->country_name = $request->input('country_name');
        $dto->updated_by   = $request->input('updated_by');
        $dto->reason       = $request->input('reason');
        return $dto;
    }
}
