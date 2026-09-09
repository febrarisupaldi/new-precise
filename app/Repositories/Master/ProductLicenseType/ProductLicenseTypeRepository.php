<?php

namespace App\Repositories\Master\ProductLicenseType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ProductLicenseTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "product_license_type");
    }
}
