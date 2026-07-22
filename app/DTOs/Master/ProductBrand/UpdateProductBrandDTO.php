<?php

namespace App\DTOs\Master\ProductBrand;


use App\DTOs\Traits\AuditDTO;
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductBrandDTO extends BaseDTO
{
    use AuditDTO;
    public string $product_brand_name;
    public bool $is_active;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_brand_name = $request->input('product_brand_name');
        $dto->is_active = $request->input('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
