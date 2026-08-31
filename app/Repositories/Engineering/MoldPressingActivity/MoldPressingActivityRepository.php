<?php

namespace App\Repositories\Engineering\MoldPressingActivity;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class MoldPressingActivityRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("engineering", "mold_pressing_activity");
    }
}
