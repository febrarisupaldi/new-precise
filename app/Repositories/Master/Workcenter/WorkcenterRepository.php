<?php

namespace App\Repositories\Master\Workcenter;

use App\Repositories\BaseRepository;
use App\Repositories\Master\Warehouse\WarehouseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WorkcenterRepository extends BaseRepository
{
    private WarehouseRepository $warehouseRepository;

    protected string $table = 'precise.workcenter';
    protected string $as = 'wc';
    protected string $primaryKey = 'wc.workcenter_id';
    protected array $columns = [
        'wc.workcenter_id',
        'wc.workcenter_code',
        'wc.workcenter_name',
        'wc.workcenter_description',
        'wc.default_warehouse',
        'wc.is_active',
        'wc.production_type',
        'wc.production_center',
        'wc.subprocess_level',
        'wc.created_on',
        'wc.created_by',
        'wc.updated_on',
        'wc.updated_by'
    ];

    protected array $allowedExistsColumns = [
        ["workcenter_code"],
        ["workcenter_name"]
    ];

    public function __construct(WarehouseRepository $warehouseRepository)
    {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function all(?array $filters = null): Builder
    {
        return parent::all()
            ->addSelect(
                DB::raw(
                    "concat(wh.warehouse_code, ' - ', wh.warehouse_name) 'Gudang default'
                        , case wc.is_active 
                            when 0 then 'Tidak aktif'
                            when 1 then 'Aktif' 
                        end as 'Status aktif'
                    "
                )
            )
            ->leftJoin(
                $this->warehouseRepository->table . ' as ' . $this->warehouseRepository->as,
                'wc.default_warehouse',
                '=',
                $this->warehouseRepository->primaryKey
            )->when($filters['code'] ?? null, function ($query) use ($filters) {
                return $query->where('wc.workcenter_code', $filters['code']);
            });
    }

    public function find(int|string $id): Builder
    {
        $this->removeColumn(["wc.default_warehouse"]);
        return parent::find($id)
            ->addSelect(
                "wh.warehouse_id",
                "wh.warehouse_code",
                "wh.warehouse_name"
            )
            ->leftJoin(
                $this->warehouseRepository->table . ' as ' . $this->warehouseRepository->as,
                'wc.default_warehouse',
                '=',
                $this->warehouseRepository->primaryKey
            );
    }
}
