<?php

namespace App\Repositories\Master\SteelType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class SteelTypeRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table("master", "steel_type");
    }
}
