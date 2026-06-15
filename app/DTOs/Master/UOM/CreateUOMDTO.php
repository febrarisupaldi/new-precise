<?php

namespace App\DTOs\Master\UOM;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateUOMDTO extends BaseDTO
{
    // Define properties here
    public string $uom_code;
    public string $uom_name;
    public bool $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->uom_code = $request->input('uom_code');
        $dto->uom_name = $request->input('uom_name');
        $dto->is_active = (bool) $request->input('is_active');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
