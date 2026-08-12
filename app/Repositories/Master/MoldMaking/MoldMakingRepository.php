<?php

namespace App\Repositories\Master\MoldMaking;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class MoldMakingRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "mold_making");
    }
}
