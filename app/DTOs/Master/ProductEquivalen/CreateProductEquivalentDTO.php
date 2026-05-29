<?php

namespace App\DTOs\Master\ProductEquivalent;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductEquivalentDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public string $product_code;
    public string $uom_code;
    public int $qty_std;
    public int $qty_conversion;
    public string $updated_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_code = $request->input('product_code');
        $dto->uom_code = $request->input('uom_code');
        $dto->qty_std = $request->input('qty_std');
        $dto->qty_conversion = $request->input('qty_conversion');
        $dto->updated_by = $request->input('updated_by');
        
        return $dto;
    }
}
