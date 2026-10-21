<?php

namespace App\DTOs\Master\CostCenter;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCostCenterDTO extends BaseDTO
{
    public function __construct(
        public readonly ?string $cost_center_code,
        public readonly ?string $cost_center_name,
        public readonly ?string $cost_center_alias,
        public readonly ?string $cc_group_code,
        public readonly ?string $cc_prod_center,
        public readonly ?string $cc_revenue_center,
        public readonly ?string $cc_profic_center,
        public readonly ?string $pr_group,
        public readonly ?string $fg_cost_center,
        public readonly ?string $fg_prod_center,
        public readonly ?string $fg_revenue_center,
        public readonly ?string $active_date,
        public readonly ?string $approved_by,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            cost_center_code: (string) $data['cost_center_code'] ?? null,
            cost_center_name: (string) $data['cost_center_name'] ?? null,
            cost_center_alias: (string) $data['cost_center_alias'] ?? null,
            cc_group_code: (string) $data['cc_group_code'] ?? null,
            cc_prod_center: (string) $data['cc_prod_center'] ?? null,
            cc_revenue_center: (string) $data['cc_revenue_center'] ?? null,
            cc_profic_center: (string) $data['cc_profic_center'] ?? null,
            pr_group: (string) $data['pr_group'] ?? null,
            fg_cost_center: (string) $data['fg_cost_center'] ?? null,
            fg_prod_center: (string) $data['fg_prod_center'] ?? null,
            fg_revenue_center: (string) $data['fg_revenue_center'] ?? null,
            active_date: (string) $data['active_date'] ?? null,
            approved_by: (string) $data['approved_by'],
            created_by: (string) $data['created_by']
        );
    }
}
