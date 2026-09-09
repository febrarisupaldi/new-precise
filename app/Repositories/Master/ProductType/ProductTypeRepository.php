<?php

namespace App\Repositories\Master\ProductType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_type");
    }
}
