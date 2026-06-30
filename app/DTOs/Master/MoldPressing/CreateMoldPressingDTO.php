<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldPressingDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        // $dto->property = $request->input('property');
        return $dto;
    }
}
