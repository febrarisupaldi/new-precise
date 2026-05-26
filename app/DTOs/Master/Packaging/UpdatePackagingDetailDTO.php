<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdatePackagingDetailDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here
    public int $packaging_dt_id;
    public int $product_id;
    public ?int $item_id = null;
    public string $item_code;
    public int $product_qty;
    public int $priority;
    public int $usage_per_unit;
    public string $updated_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->packaging_dt_id = (int) $request->input('packaging_dt_id') ?? null;
        $dto->product_id = (int) $request->input('product_id');
        $dto->item_id = (int) $request->input('item_id') ?? null;
        $dto->item_code = $request->input('item_code');
        $dto->product_qty = (int) $request->input('product_qty');
        $dto->priority = (int) $request->input('priority');
        $dto->usage_per_unit = (int) $request->input('usage_per_unit');
        $dto->updated_by = $request->input('updated_by');

        return $dto;
    }
}
