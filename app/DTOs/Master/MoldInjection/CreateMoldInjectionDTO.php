<?php

namespace App\DTOs\Master\MoldInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldInjectionDTO extends BaseDTO
{
    

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        
        return $dto;
    }
}
