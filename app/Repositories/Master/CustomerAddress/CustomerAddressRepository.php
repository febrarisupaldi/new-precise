<?php

namespace App\Repositories\Master\CustomerAddress;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class CustomerAddressRepository extends BaseRepository
{
    protected Table $table;
    protected Table $city;
    protected Table $customer;
    protected Table $addressType;

    public function __construct()
    {
        $this->table = table('master', 'customer_address');
        $this->city = table('master', 'city')->withAlias('ct');
        $this->customer = table('master', 'customer')->withAlias('cust');
        $this->addressType = table('master', 'address_type');
    }

    private function join(Builder $query): void
    {


        JoinBuilder::leftJoin(
            $query,
            $this->customer,
            $this->table->column('customer_id'),
            '=',
            $this->customer->column('customer_id')
        );
        JoinBuilder::leftJoin(
            $query,
            $this->addressType,
            $this->table->column('address_type_id'),
            '=',
            $this->addressType->column('address_type_id')
        );
        JoinBuilder::leftJoin(
            $query,
            $this->city,
            $this->table->column('city_id'),
            '=',
            $this->city->column('city_id')
        );
    }

    public function index(callable $callback): bool
    {
        $query = parent::all();

        $this->join($query);

        return $query->addSelect(
            $this->customer->column('customer_code'),
            $this->customer->column('customer_name'),
            $this->city->column('city_name'),
            $this->addressType->column('address_type_name')
        )
            ->chunkById(20000, function ($rows) use ($callback) {
                foreach ($rows as $row) {
                    $callback($row);
                }
            }, $this->table->pk());
    }

    public function show(mixed $id): Builder
    {
        $query = parent::find($id);

        $this->join($query);

        return $query->addSelect(
            $this->customer->column('customer_code'),
            $this->customer->column('customer_name'),
            $this->city->column('city_name'),
            $this->addressType->column('address_type_name')
        );
    }
}
