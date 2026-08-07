<?php

namespace App\Repositories\Master\Workcenter;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\Warehouse\WarehouseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WorkcenterRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table("master", "workcenter");
    }

    public function all(?array $filters = null): Builder
    {
        $query = parent::all();

        $warehouse = table("master", "warehouse")->withAlias("wh");

        JoinBuilder::leftJoin(
            $query,
            $warehouse,
            $this->table->column("default_warehouse"),
            "=",
            $warehouse->pk(),
        );

        return $query
            ->addSelect(
                DB::raw(
                    "concat({$warehouse->column('warehouse_code')}, ' - ', {$warehouse->column('warehouse_name')}) 'Gudang default'
                        , case {$this->table->column('is_active')} 
                            when 0 then 'Tidak aktif'
                            when 1 then 'Aktif' 
                        end as 'Status aktif'
                    "
                )
            )
            ->when($filters['code'] ?? null, function ($query) use ($filters) {
                return $query->where($this->table->column('workcenter_code'), $filters['code']);
            });
    }

    public function find(mixed $id): Builder
    {
        $this->table->except(["default_warehouse"]);

        $query = parent::find($id);

        $warehouse = table("master", "warehouse");

        JoinBuilder::leftJoin(
            $query,
            $warehouse,
            $this->table->column("default_warehouse"),
            "=",
            $warehouse->pk(),
        );

        return $query
            ->addSelect(
                $warehouse->column("warehouse_id"),
                $warehouse->column("warehouse_code"),
                $warehouse->column("warehouse_name")
            );
    }
}
