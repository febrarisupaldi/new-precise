<?php

namespace App\Http\Requests\Master\Customer;

use App\Http\Requests\BaseApiRequest;

class CreateCustomerRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_code'         => ['required', 'string', 'max:15', 'unique:customer,customer_code'],
            'customer_name'         => ['required', 'string', 'max:100'],
            'customer_alias_name'   => ['nullable', 'string', 'max:50'],
            'company_type_id'       => ['nullable', 'unique:company_type,company_type_id'],
            'retail_type_id'        => ['nullable', 'unique:retail_type,retail_type_id'],
            'npwp'                  => ['nullable', 'string', 'max:30'],
            'pkp_name'              => ['nullable', 'string', 'max:100'],
            'fg_credit_limit'       => ['nullable', 'string', 'max:1'],
            'fg_credit_term'        => ['nullable', 'string', 'max:1'],
            'discount_type'         => ['nullable', 'string', 'max:1'],
            'ppn_type'              => ['nullable', 'string', 'max:1'],
            'head_office'           => ['nullable', 'string', 'max:15'],
            'city_id'               => ['nullable', 'exists:city,city_id'],
            'ar_coa_id'             => ['nullable', 'exists:coa_old,coa_id'],
            'ar_sub_ledger_acc'     => ['nullable', 'string', 'max:18'],
            'ar_response_code'      => ['nullable', 'string', 'max:8'],
            'pdc_sub_ledger_acc'    => ['nullable', 'string', 'max:18'],
            'pdc_response_code'     => ['nullable', 'string', 'max:8'],
            'sa_sub_ledger_acc'     => ['nullable', 'string', 'max:18'],
            'sa_response_code'      => ['nullable', 'string', 'max:8'],
            'fg_clt_ppn'            => ['nullable', 'string', 'max:1'],
            'fg_pet'                => ['nullable', 'string', 'max:1'],
            'fg_customer_type'      => ['nullable', 'string', 'max:1'],
            'fg_article'            => ['nullable', 'string', 'max:1'],
            'fg_tax_form'           => ['nullable', 'string', 'max:1'],
            'fg_kbn'                => ['nullable', 'string', 'max:1'],
            'fg_bi'                 => ['nullable', 'string', 'max:1'],
            'fg_pph22'              => ['nullable', 'string', 'max:1'],
            'price_group_code'      => ['nullable', 'string', 'max:10'],
            'disc_group_code'       => ['nullable', 'string', 'max:10'],
            'disc_1'                => ['nullable', 'decimal:4'],
            'disc_2'                => ['nullable', 'decimal:4'],
            'disc_3'                => ['nullable', 'decimal:4'],
            'customer_description'  => ['nullable', 'string', 'max:100'],
            'customer_old_id'       => ['nullable', 'string', 'max:15'],
            'is_active'             => ['nullable', 'bool'],
            'approval_status'       => ['nullable', 'string', 'max:1'],
            'approved_by'           => ['nullable', 'integer'],
            'created_by'            => ['required', 'string', 'max:100'],
        ];
    }
}
