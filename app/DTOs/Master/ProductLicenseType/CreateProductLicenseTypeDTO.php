<?php

namespace App\DTOs\Master\ProductLicenseType;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductLicenseTypeDTO extends BaseDTO
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
