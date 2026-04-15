<?php

namespace App\DTOs\Master\State;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateStateDTO extends BaseDTO
{
    public string $state_code;
    public string $state_name;
    public int $country_id;
    public string $updated_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->state_code = $request->input('state_code');
        $dto->state_name = $request->input('state_name');
        $dto->country_id = (int) $request->input('country_id');
        $dto->updated_by = $request->input('updated_by');
        return $dto;
    }
}
