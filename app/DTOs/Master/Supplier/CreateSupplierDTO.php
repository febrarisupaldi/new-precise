<?php

namespace App\DTOs\Master\Supplier;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSupplierDTO extends BaseDTO
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
