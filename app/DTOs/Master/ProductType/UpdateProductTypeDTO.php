<?php

namespace App\DTOs\Master\ProductType;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public string $product_type_code;
    public string $product_type_name;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_type_code = $request->input('product_type_code');
        $dto->product_type_name = $request->input('product_type_name');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');
        return $dto;
    }
}
