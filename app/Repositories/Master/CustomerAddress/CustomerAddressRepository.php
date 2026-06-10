<?php

namespace App\Repositories\Master\CustomerAddress;

use App\Repositories\BaseRepository;
use App\Repositories\Master\AddressType\AddressTypeRepository;
use App\Repositories\Master\City\CityRepository;
use App\Repositories\Master\Customer\CustomerRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class CustomerAddressRepository extends BaseRepository
{
    private CustomerRepository $customerRepository;
    private AddressTypeRepository $addressTypeRepository;
    private CityRepository $cityRepository;
    protected string $table = 'precise.customer_address';
    protected string $as = 'ca';
    protected string $primaryKey = 'ca.customer_address_id';
    protected array $columns = [
        'ca.customer_address_id',
        'ca.customer_id',
        'ca.address_type_id',
        'ca.is_default',
        'ca.address',
        'ca.subdistrict',
        'ca.district',
        'ca.city_id',
        'ca.zipcode',
        'ca.phone_number',
        'ca.fax_number',
        'ca.email',
        'ca.website',
        'ca.off_hour',
        'ca.contact_person',
        'ca.religion',
        'ca.created_on',
        'ca.created_by',
        'ca.updated_on',
        'ca.updated_by'
    ];

    public function __construct(CustomerRepository $customerRepository,
    AddressTypeRepository $addressTypeRepository, 
    CityRepository $cityRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->addressTypeRepository = $addressTypeRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index(callable $callback): bool
    {
        $this->cityRepository->setAlias('ct');
        $this->cityRepository->setPrimaryKey("ct.city_id");
        
        return parent::all()->addSelect(
            "c.customer_code",
            "c.customer_name",
            "ct.city_name",
            "at.address_type_name"
        )
            ->leftJoin($this->customerRepository->table . ' as ' . $this->customerRepository->as, 
            'ca.customer_id', 
            '=', $this->customerRepository->primaryKey)
            ->leftJoin($this->addressTypeRepository->table . ' as ' . $this->addressTypeRepository->as,
            'ca.address_type_id', 
            '=', $this->addressTypeRepository->primaryKey)
            ->leftJoin($this->cityRepository->table . ' as ' . $this->cityRepository->as, 
            'ca.city_id', 
            '=', $this->cityRepository->primaryKey)
            ->chunkById(20000, function($rows) use ($callback){
                foreach($rows as $row){
                    $callback($row);
                }
            }, "customer_address_id");
    }

    public function show(int $id): Builder
    {
        $this->cityRepository->setAlias('ct');
        
        return parent::find($id)->addSelect(
            "c.customer_code",
            "c.customer_name",
            "ct.city_name",
            "at.address_type_name"
        )
            ->leftJoin($this->customerRepository->table . ' as ' . $this->customerRepository->as, 
            'ca.customer_id', 
            '=', $this->customerRepository->primaryKey)
            ->leftJoin($this->addressTypeRepository->table . ' as ' . $this->addressTypeRepository->as,
            'ca.address_type_id', 
            '=', $this->addressTypeRepository->primaryKey)
            ->leftJoin($this->cityRepository->table . ' as ' . $this->cityRepository->as, 
            'ca.city_id', 
            '=', $this->cityRepository->primaryKey)
            ->where($this->primaryKey, $id)
            ;
    }
}
