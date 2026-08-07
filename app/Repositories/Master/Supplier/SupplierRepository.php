<?php

namespace App\Repositories\Master\Supplier;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table("master", "supplier");
    }
}
