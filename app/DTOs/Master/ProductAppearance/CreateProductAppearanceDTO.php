<?php

namespace App\DTOs\Master\ProductAppearance;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductAppearanceDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public ?string $appearance_name;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->appearance_name = $request->input('appearance_name');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
