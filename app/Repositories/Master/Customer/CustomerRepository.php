<?php

namespace App\Repositories\Master\Customer;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\AddressType\AddressTypeRepository;
use App\Repositories\Master\City\CityRepository;
use App\Repositories\Master\CustomerAddress\CustomerAddressRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository
{

    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'customer');
    }

    public function findAddressesByCustomerIDs(array $customerIDs): Builder
    {
        $query = parent::all();

        $customerAddress = table("master", "customer_address");
        $city = table("master", "city")->withAlias("ct");
        $addressType = table("master", "address_type");

        JoinBuilder::leftJoin(
            $query,
            $customerAddress,
            $customerAddress->pk(),
            '=',
            $this->table->column("customer_id")
        );
        JoinBuilder::leftJoin(
            $query,
            $addressType,
            $addressType->pk(),
            '=',
            $customerAddress->column("address_type_id")
        );
        JoinBuilder::leftJoin(
            $query,
            $city,
            $city->pk(),
            '=',
            $this->table->column("city_id")
        );

        return $query->addSelect(
            $this->table->column("customer_code"),
            $this->table->column("customer_name"),
            $city->column("city_name"),
            $addressType->column("address_type_name")
        )->whereIn($customerAddress->column("customer_id"), $customerIDs);
    }
}
