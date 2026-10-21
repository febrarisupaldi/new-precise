<?php

namespace App\DTOs\Master\Customer;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCustomerDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $customer_code,
        public readonly string $customer_name,
        public readonly string $customer_alias_name,
        public readonly int $company_type_id,
        public readonly int $retail_type_id,
        public readonly ?string $npwp,
        public readonly ?string $pkp_name,
        public readonly ?string $fg_credit_limit,
        public readonly ?string $fg_credit_term,
        public readonly ?string $discount_type,
        public readonly ?string $ppn_type,
        public readonly ?string $head_office,
        public readonly ?int $city_id,
        public readonly ?int $ar_coa_id,
        public readonly ?string $ar_sub_ledger_acc,
        public readonly ?string $ar_response_code,
        public readonly ?string $pdc_sub_ledger_acc,
        public readonly ?string $pdc_response_code,
        public readonly ?string $sa_sub_ledger_acc,
        public readonly ?string $sa_response_code,
        public readonly ?string $fg_clt_ppn,
        public readonly ?string $fg_pet,
        public readonly ?string $fg_customer_type,
        public readonly ?string $fg_article,
        public readonly ?string $fg_tax_form,
        public readonly ?string $fg_kbn,
        public readonly ?string $fg_bi,
        public readonly ?string $fg_pph22,
        public readonly ?string $price_group_code,
        public readonly ?string $disc_group_code,
        public readonly ?float $disc_1,
        public readonly ?float $disc_2,
        public readonly ?float $disc_3,
        public readonly ?string $customer_description,
        public readonly ?string $customer_old_id,
        public readonly ?bool $is_active,
        public readonly ?string $approval_status,
        public readonly ?int $approved_by,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            customer_code: (string) $data['customer_code'],
            customer_name: (string) $data['customer_name'],
            customer_alias_name: (string) $data['customer_alias_name'],
            company_type_id: (int) $data['company_type_id'],
            retail_type_id: (int) $data['retail_type_id'],
            npwp: (string) $data['npwp'] ?? null,
            pkp_name: (string) $data['pkp_name'] ?? null,
            fg_credit_limit: (string) $data['fg_credit_limit'] ?? null,
            fg_credit_term: (string) $data['fg_credit_term'] ?? null,
            discount_type: (string) $data['discount_type'] ?? null,
            ppn_type: (string) $data['ppn_type'] ?? null,
            head_office: (string) $data['head_office'] ?? null,
            city_id: (int) $data['city_id'] ?? null,
            ar_coa_id: (int) $data['ar_coa_id'] ?? null,
            ar_sub_ledger_acc: (string) $data['ar_sub_ledger_acc'] ?? null,
            ar_response_code: (string) $data['ar_response_code'] ?? null,
            pdc_sub_ledger_acc: (string) $data['pdc_sub_ledger_acc'] ?? null,
            pdc_response_code: (string) $data['pdc_response_code'] ?? null,
            sa_sub_ledger_acc: (string) $data['sa_sub_ledger_acc'] ?? null,
            sa_response_code: (string) $data['sa_response_code'] ?? null,
            fg_clt_ppn: (string) $data['fg_clt_ppn'] ?? null,
            fg_pet: (string) $data['fg_pet'] ?? null,
            fg_customer_type: (string) $data['fg_customer_type'] ?? null,
            fg_article: (string) $data['fg_article'] ?? null,
            fg_tax_form: (string) $data['fg_tax_form'] ?? null,
            fg_kbn: (string) $data['fg_kbn'] ?? null,
            fg_bi: (string) $data['fg_bi'] ?? null,
            fg_pph22: (string) $data['fg_pph22'] ?? null,
            price_group_code: (string) $data['price_group_code'] ?? null,
            disc_group_code: (string) $data['disc_group_code'] ?? null,
            disc_1: (float) $data['disc_1'] ?? null,
            disc_2: (float) $data['disc_2'] ?? null,
            disc_3: (float) $data['disc_3'] ?? null,
            customer_description: (string) $data['customer_description'] ?? null,
            customer_old_id: (string) $data['customer_old_id'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            approval_status: (string) $data['approval_status'] ?? null,
            approved_by: (int) $data['approved_by'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
