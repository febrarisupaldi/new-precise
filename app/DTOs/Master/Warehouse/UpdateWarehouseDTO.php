<?php

namespace App\DTOs\Master\Warehouse;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateWarehouseDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $warehouse_code,
        public readonly string $warehouse_name,
        public readonly ?string $warehouse_alias,
        public readonly string $warehouse_group_code,
        public readonly bool $is_active,
        public readonly ?int $warehouse_pic_1,
        public readonly ?int $warehouse_pic_2,
        public readonly ?int $warehouse_approver,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            warehouse_code: (string) strtoupper($data['warehouse_code']),
            warehouse_name: (string) $data['warehouse_name'],
            warehouse_alias: (string) $data['warehouse_alias'],
            warehouse_group_code: (string) $data['warehouse_group_code'],
            is_active: (bool) $data['is_active'],
            warehouse_pic_1: (int) $data['warehouse_pic_1'],
            warehouse_pic_2: (int) $data['warehouse_pic_2'],
            warehouse_approver: (int) $data['warehouse_approver'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
