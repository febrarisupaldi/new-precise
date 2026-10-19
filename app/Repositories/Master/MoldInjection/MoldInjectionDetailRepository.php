<?php

namespace App\Repositories\Master\MoldInjection;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MoldInjectionDetailRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "mold_injection.detail");
    }

    public function showByMasterID(int $id): Builder
    {
        return parent::all()->where($this->table->column("mold_injection_hd_id"), $id);
    }
}
