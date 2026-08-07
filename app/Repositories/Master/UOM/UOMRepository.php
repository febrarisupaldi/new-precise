<?php

namespace App\Repositories\Master\UOM;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class UOMRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table("master", "uom");
    }
}
