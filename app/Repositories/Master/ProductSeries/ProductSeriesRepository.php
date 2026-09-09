<?php

namespace App\Repositories\Master\ProductSeries;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductSeriesRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_series");
    }
}
