<?php

namespace App\Repositories\Master\Product;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{

    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'product');
    }
}
