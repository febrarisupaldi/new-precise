<?php

namespace App\DTOs\Master\RetailType;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateRetailTypeDTO extends BaseDTO
{
    // Define properties here
    public string $retail_type_code;
    public string $retail_type_description;
    public string $groupcodeonproint;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->retail_type_code = $request->input('retail_type_code');
        $dto->retail_type_description = $request->input('retail_type_description');
        $dto->groupcodeonproint = $request->input('groupcodeonproint');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
