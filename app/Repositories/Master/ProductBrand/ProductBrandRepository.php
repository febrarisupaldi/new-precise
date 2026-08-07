<?php

namespace App\Repositories\Master\ProductBrand;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class ProductBrandRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_brand");
    }
}
