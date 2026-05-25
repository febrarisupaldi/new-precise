<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingDetailDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public int $product_id;
    public int $item_id;
    public string $item_code;
    public int $product_qty;
    public int $priority;
    public int $usage_per_unit;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->product_id = (int) $request->input("product_id");
        $dto->item_id = (int) $request->input("item_id");
        $dto->item_code = $request->input("item_code");
        $dto->product_qty = (int) $request->input("product_qty");
        $dto->priority = (int) $request->input("priority");
        $dto->usage_per_unit = (int) $request->input("usage_per_unit");
        $dto->created_by = $request->input("created_by");
        return $dto;
    }
}
