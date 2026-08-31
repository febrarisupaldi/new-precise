<?php

namespace App\Repositories\Master\CostCenter;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class CostCenterRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "cost_center");
    }
}
