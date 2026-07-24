<?php

namespace App\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class ExistsDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public array $conditions;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->conditions = $request->query();
        return $dto;
    }
}
