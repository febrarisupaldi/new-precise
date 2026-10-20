<?php

namespace App\DTOs\PPIC\MaterialUsage;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMaterialUsageDTO extends BaseDTO
{
    // Define properties here
    // public $property;



    public static function fromArray(array $data): static
    {
        return new static(
            // Define properties here
        );
    }
}
