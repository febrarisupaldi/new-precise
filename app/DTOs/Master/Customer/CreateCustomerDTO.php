<?php

namespace App\DTOs\Master\Customer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use Override;

class CreateCustomerDTO extends BaseDTO
{

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
        public readonly ?string $city_id,
        public readonly ?string $ar_coa_id,
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
        public readonly ?string $disc_1,
        public readonly ?string $disc_2,
        public readonly ?string $disc_3,
        public readonly ?string $customer_description,
        public readonly ?string $customer_old_id,
        public readonly ?bool $is_active,
        public readonly ?string $approval_status,
        public readonly ?string $approved_by,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            customer_code: (string) $data['customer_code'],
            customer_name: (string) $data['customer_name'],
            customer_alias_name: (string) $data['customer_alias_name'],
            company_type_id: (int) $data['company_type_id'],
            retail_type_id: (int) $data['retail_type_id'],
            npwp: (string) $data['npwp'],
            pkp_name: (string) $data['pkp_name'],
            fg_credit_limit: (string) $data['fg_credit_limit'],
            fg_credit_term: (string) $data['fg_credit_term'],
            discount_type: (string) $data['discount_type'],
            ppn_type: (string) $data['ppn_type'],
            head_office: (string) $data['head_office'],
            city_id: (string) $data['city_id'],
            ar_coa_id: (string) $data['ar_coa_id'],
            ar_sub_ledger_acc: (string) $data['ar_sub_ledger_acc'],
            ar_response_code: (string) $data['ar_response_code'],
            pdc_sub_ledger_acc: (string) $data['pdc_sub_ledger_acc'],
            pdc_response_code: (string) $data['pdc_response_code'],
            sa_sub_ledger_acc: (string) $data['sa_sub_ledger_acc'],
            sa_response_code: (string) $data['sa_response_code'],
            fg_clt_ppn: (string) $data['fg_clt_ppn'],
            fg_pet: (string) $data['fg_pet'],
            fg_customer_type: (string) $data['fg_customer_type'],
            fg_article: (string) $data['fg_article'],
            fg_tax_form: (string) $data['fg_tax_form'],
            fg_kbn: (string) $data['fg_kbn'],
            fg_bi: (string) $data['fg_bi'],
            fg_pph22: (string) $data['fg_pph22'],
            price_group_code: (string) $data['price_group_code'],
            disc_group_code: (string) $data['disc_group_code'],
            disc_1: (string) $data['disc_1'],
            disc_2: (string) $data['disc_2'],
            disc_3: (string) $data['disc_3'],
            customer_description: (string) $data['customer_description'],
            customer_old_id: (string) $data['customer_old_id'],
            is_active: (bool) $data['is_active'],
            approval_status: (string) $data['approval_status'],
            approved_by: (string) $data['approved_by'],
            created_by: (string) $data['created_by']
        );
    }
}
