<?php

namespace App\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class ExistsDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public array $columns;
    public array $values;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->columns = $request->input('columns');
        $dto->values = $request->input('values');
        return $dto;
    }
}
