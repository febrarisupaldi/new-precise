<?php

namespace App\Repositories\Master\RetailType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class RetailTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "retail_type");
    }
}
