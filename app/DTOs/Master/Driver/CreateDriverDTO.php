<?php

namespace App\DTOs\Master\Driver;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateDriverDTO extends BaseDTO
{
    public string $driver_nik;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->driver_nik = $request->input('driver_nik');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
