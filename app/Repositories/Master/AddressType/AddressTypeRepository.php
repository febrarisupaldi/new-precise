<?php

namespace App\Repositories\Master\AddressType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class AddressTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "address_type");
    }
}
