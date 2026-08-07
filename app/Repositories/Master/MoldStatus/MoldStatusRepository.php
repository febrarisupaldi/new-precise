<?php

namespace App\Repositories\Master\MoldStatus;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class MoldStatusRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "mold_status");
    }
}
