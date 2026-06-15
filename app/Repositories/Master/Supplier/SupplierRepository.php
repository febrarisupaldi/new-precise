<?php

namespace App\Repositories\Master\Supplier;

use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository
{
    protected string $table = 'precise.supplier';
    protected string $as = 's';
    protected string $primaryKey = 's.supplier_id';
    protected array $columns = [
        's.supplier_id',
        's.supplier_code',
        's.supplier_name',
        's.supplier_alias_name',
        's.origin',
        's.supplier_group_code',
        's.company_type_id',
        's.supplier_addr1',
        's.supplier_addr2',
        's.city_id',
        's.supplier_zip_code',
        's.supplier_phone1',
        's.supplier_phone2',
        's.supplier_phone3',
        's.supplier_fax1',
        's.supplier_fax2',
        's.supplier_email',
        's.supplier_website',
        's.npwp',
        's.pkp_name',
        's.ppn_type',
        's.supplier_credit_term',
        's.supplier_credit_limit',
        's.ap_coa_id',
        's.created_on',
        's.created_by',
        's.updated_on',
        's.updated_by'
    ];

    // Add custom repository methods here
}
