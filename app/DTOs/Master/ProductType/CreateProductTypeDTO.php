<?php

namespace App\DTOs\Master\ProductType;

// php namespace
use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class CreateProductTypeDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    use AuditDTO;
    public string $product_type_code;
    public string $product_type_name;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_type_code = $request->input('product_type_code');
        $dto->product_type_name = $request->input('product_type_name');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
