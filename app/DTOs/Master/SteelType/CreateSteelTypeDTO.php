<?php

namespace App\DTOs\Master\SteelType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSteelTypeDTO extends BaseDTO
{
    public string $steel_type_name;
    public ?bool $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->steel_type_name = $request->input('steel_type_name');
        $dto->is_active        = $request->input('is_active') ?? true;
        $dto->created_by      = $request->input('created_by');
        return $dto;
    }
}
