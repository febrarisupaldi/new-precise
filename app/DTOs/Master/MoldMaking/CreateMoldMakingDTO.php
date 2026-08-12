<?php

namespace App\DTOs\Master\MoldMaking;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldMakingDTO extends BaseDTO
{
    public string $estimation_number;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->estimation_number = $request->input('estimation_number');
        $dto->created_by        = $request->input('created_by');
        return $dto;
    }
}
