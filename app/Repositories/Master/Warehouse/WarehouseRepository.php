<?php

namespace App\Repositories\Master\Warehouse;

use App\Repositories\BaseRepository;
use App\Repositories\Master\WarehouseGroup\WarehouseGroupRepository;
use Illuminate\Database\Query\Builder;

class WarehouseRepository extends BaseRepository
{
    private WarehouseGroupRepository $warehouseGroupRepo;
    protected string $table = 'precise.warehouse';
    protected string $as = 'w';
    protected string $primaryKey = 'warehouse_id';
    protected array $columns = [
        'w.warehouse_id',
        'w.warehouse_code',
        'w.warehouse_name',
        'w.warehouse_alias',
        'w.warehouse_group_code',
        'w.is_active',
        'w.warehouse_pic_1',
        'w.warehouse_pic_2',
        'w.warehouse_approver',
        'w.created_on',
        'w.created_by',
        'w.updated_on',
        'w.updated_by'
    ];

    public function __construct(WarehouseGroupRepository $warehouseGroupRepo)
    {
        $this->warehouseGroupRepo = $warehouseGroupRepo;
    }

    public function all(): Builder
    {
        return parent::all()
            ->addSelect("wg.warehouse_group_name")
            ->join($this->warehouseGroupRepo->getTable() . " as wg",
                $this->warehouseGroupRepo->getPrimaryKey(),
                "=",
                "w.warehouse_group_code");
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("wg.warehouse_group_name")
            ->join($this->warehouseGroupRepo->getTable() . " as wg",
                $this->warehouseGroupRepo->getPrimaryKey(),
                "=",
                "w.warehouse_group_code");
    }
}
