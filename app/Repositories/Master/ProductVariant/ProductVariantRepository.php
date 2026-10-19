<?php

namespace App\Repositories\Master\ProductVariant;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductVariantRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_variant");
    }
}
