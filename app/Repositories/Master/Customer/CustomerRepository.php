<?php

namespace App\Repositories\Master\Customer;

use App\Repositories\BaseRepository;
use App\Repositories\Master\AddressType\AddressTypeRepository;
use App\Repositories\Master\City\CityRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository
{

    private AddressTypeRepository $addressTypeRepo;
    private CityRepository $cityRepo;
    protected string $table = 'precise.customer'; 
    protected string $as = 'c';
    protected string $primaryKey = 'c.customer_id';
    protected array $columns = [
        'c.customer_id',
        'c.customer_code',
        'c.customer_name',
        'c.customer_alias_name',
        'c.company_type_id',
        'c.retail_type_id',
        'c.npwp',
        'c.pkp_name',
        'c.fg_credit_limit',
        'c.fg_credit_term',
        'c.discount_type',
        'c.ppn_type',
        'c.head_office',
        'c.city_id',
        'c.ar_coa_id',
        'c.ar_sub_ledger_acc',
        'c.ar_response_code',
        'c.pdc_sub_ledger_acc',
        'c.pdc_response_code',
        'c.sa_sub_ledger_acc',
        'c.sa_response_code',
        'c.fg_clt_ppn',
        'c.fg_pet',
        'c.fg_customer_type',
        'c.fg_article',
        'c.fg_tax_form',
        'c.fg_kbn',
        'c.fg_bi',
        'c.fg_pph22',
        'c.price_group_code',
        'c.disc_group_code',
        'c.disc_1',
        'c.disc_2',
        'c.disc_3',
        'c.customer_description',
        'c.customer_old_id',
        'c.is_active',
        'c.approval_status',
        'c.approved_by',
        'c.created_on',
        'c.created_by',
        'c.updated_on',
        'c.updated_by'
    ];

    public function __construct(
        AddressTypeRepository $addressTypeRepo,
        CityRepository $cityRepo
    ) {
        $this->addressTypeRepo = $addressTypeRepo;
        $this->cityRepo = $cityRepo;
    }

    public function findAddressesByCustomerIDs(array $customerIDs): Builder{
        $this->cityRepo->setAlias("ct");
        return DB::table("precise.customer_address as ca")
        ->select(
            "ca.*", 
            "c.customer_code", 
            "c.customer_name", 
            "ct.city_name", 
            "at.address_type_name"
        )
        ->leftJoin($this->table . ' as ' . $this->as, "ca.customer_id", '=', $this->primaryKey)
        ->leftJoin( "{$this->cityRepo->table} as {$this->cityRepo->as}" , "ca.city_id", '=', $this->cityRepo->primaryKey)
        ->leftJoin( "{$this->addressTypeRepo->table} as {$this->addressTypeRepo->as}" , "ca.address_type_id", '=', $this->addressTypeRepo->primaryKey)
        ->whereIn($this->primaryKey, $customerIDs);
    }
}
