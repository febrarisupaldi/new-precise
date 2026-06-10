<?php

namespace App\DTOs\Master\Customer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCustomerDTO extends BaseDTO
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
