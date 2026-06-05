<?php

namespace App\DTOs\Master\ColorType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateColorTypeDTO extends BaseDTO
{
    public string $color_type_code;
    public string $color_type_name;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->color_type_code = $request->input('color_type_code');
        $dto->color_type_name = $request->input('color_type_name');
        $dto->created_by      = $request->input('created_by');
        return $dto;
    }
}
