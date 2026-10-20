<?php

namespace App\DTOs\Master\CostCenter;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateCostCenterDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $cost_center_code,
        public readonly string $cost_center_name,
        public readonly string $cost_center_alias,
        public readonly string $cc_group_code,
        public readonly string $cc_prod_center,
        public readonly string $cc_revenue_center,
        public readonly string $cc_profic_center,
        public readonly string $pr_group,
        public readonly string $fg_cost_center,
        public readonly string $fg_prod_center,
        public readonly string $fg_revenue_center,
        public readonly string $active_date,
        public readonly string $approved_by,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            cost_center_code: (string) $data['cost_center_code'],
            cost_center_name: (string) $data['cost_center_name'],
            cost_center_alias: (string) $data['cost_center_alias'],
            cc_group_code: (string) $data['cc_group_code'],
            cc_prod_center: (string) $data['cc_prod_center'],
            cc_revenue_center: (string) $data['cc_revenue_center'],
            cc_profic_center: (string) $data['cc_profic_center'],
            pr_group: (string) $data['pr_group'],
            fg_cost_center: (string) $data['fg_cost_center'],
            fg_prod_center: (string) $data['fg_prod_center'],
            fg_revenue_center: (string) $data['fg_revenue_center'],
            active_date: (string) $data['active_date'],
            approved_by: (string) $data['approved_by'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
