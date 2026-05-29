<?php

namespace App\DTOs\Master\Warehouse;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateWarehouseDTO extends BaseDTO
{
    use AuditDTO;
    
    public string $warehouse_code;
    public string $warehouse_name;
    public ?string $warehouse_alias;
    public ?string $warehouse_group_code;
    public ?bool $is_active;
    public ?string $warehouse_pic_1;
    public ?string $warehouse_pic_2;
    public ?string $warehouse_approver;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->warehouse_code = strtoupper($request->input('warehouse_code'));
        $dto->warehouse_name = $request->input('warehouse_name');
        $dto->warehouse_alias = $request->input('warehouse_alias');
        $dto->warehouse_group_code = $request->input('warehouse_group_code');
        $dto->is_active = $request->input('is_active');
        $dto->warehouse_pic_1 = $request->input('warehouse_pic_1');
        $dto->warehouse_pic_2 = $request->input('warehouse_pic_2');
        $dto->warehouse_approver = $request->input('warehouse_approver');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
