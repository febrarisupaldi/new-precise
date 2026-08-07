<?php

namespace App\Repositories\Master\MoldInjection;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class MoldInjectionDetailRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("precise", "mold_injection.detail");
    }
}
