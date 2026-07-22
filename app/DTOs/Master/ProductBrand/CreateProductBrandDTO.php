<?php

namespace App\DTOs\Master\ProductBrand;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductBrandDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public string $product_brand_name;
    public bool $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_brand_name = $request->input('product_brand_name');
        $dto->is_active = $request->input('is_active');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
