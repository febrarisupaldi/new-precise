<?php

namespace App\Repositories\Master\ProductGroup;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductGroupRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_group");
    }
}
