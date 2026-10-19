<?php

namespace App\DTOs\Master\Warehouse;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateWarehouseDTO extends BaseDTO
{
    public function __construct(
        public readonly string $warehouse_code,
        public readonly string $warehouse_name,
        public readonly ?string $warehouse_alias,
        public readonly string $warehouse_group_code,
        public readonly bool $is_active,
        public readonly ?int $warehouse_pic_1,
        public readonly ?int $warehouse_pic_2,
        public readonly ?int $warehouse_approver,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            warehouse_code: (string) strtoupper($request->input('warehouse_code')),
            warehouse_name: (string) $request->input('warehouse_name'),
            warehouse_alias: (string) $request->input('warehouse_alias'),
            warehouse_group_code: (string) $request->input('warehouse_group_code'),
            is_active: (bool) $request->input('is_active', true),
            warehouse_pic_1: (int) $request->input('warehouse_pic_1'),
            warehouse_pic_2: (int) $request->input('warehouse_pic_2'),
            warehouse_approver: (int) $request->input('warehouse_approver'),
            created_by: (string) $request->input('created_by')
        );
    }
}
