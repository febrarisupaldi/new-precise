<?php

namespace App\Repositories\Master\CoolingMethod;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class CoolingMethodRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "cooling_method");
    }
}
