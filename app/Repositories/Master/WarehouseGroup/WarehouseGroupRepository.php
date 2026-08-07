<?php

namespace App\Repositories\Master\WarehouseGroup;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class WarehouseGroupRepository extends BaseRepository
{
    protected Table $warehouseGroup;

    public function __construct()
    {
        $this->warehouseGroup = table("master", "warehouse_group");
    }

    // Add custom repository methods here
}
