<?php

namespace App\Repositories\Master\MoldInjection;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class MoldInjectionDetailCavityRepository extends BaseRepository
{
    protected Table $table;
    protected Table $moldInjectionDetail;

    public function __construct()
    {
        $this->table = table("master", "mold_injection.detail.cavity");
        $this->moldInjectionDetail = table("master", "mold_injection.detail");
    }

    public function showByDetailID(int $id): Builder
    {
        $query = parent::all();
        JoinBuilder::leftJoin(
            $query,
            $this->moldInjectionDetail,
            $this->moldInjectionDetail->column("mold_injection_dt_id"),
            '=',
            $this->table->pk()
        );
        return $query->where($this->moldInjectionDetail->column("mold_injection_dt_id"), $id);
    }
}
