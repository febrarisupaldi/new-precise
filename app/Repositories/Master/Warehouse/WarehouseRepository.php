<?php

namespace App\Repositories\Master\Warehouse;

use App\Repositories\BaseRepository;
use App\Repositories\Master\WarehouseGroup\WarehouseGroupRepository;
use Illuminate\Database\Query\Builder;

class WarehouseRepository extends BaseRepository
{
    private WarehouseGroupRepository $warehouseGroupRepo;
    protected string $table = 'precise.warehouse';
    protected string $as = 'wh';
    protected string $primaryKey = 'wh.warehouse_id';
    protected array $columns = [
        'wh.warehouse_id',
        'wh.warehouse_code',
        'wh.warehouse_name',
        'wh.warehouse_alias',
        'wh.warehouse_group_code',
        'wh.is_active',
        'wh.warehouse_pic_1',
        'wh.warehouse_pic_2',
        'wh.warehouse_approver',
        'wh.created_on',
        'wh.created_by',
        'wh.updated_on',
        'wh.updated_by'
    ];

    public function __construct(WarehouseGroupRepository $warehouseGroupRepo)
    {
        $this->warehouseGroupRepo = $warehouseGroupRepo;
    }

    public function all(?array $filters = null): Builder
    {
        return parent::all()
            ->addSelect("wg.warehouse_group_name")
            ->join($this->warehouseGroupRepo->getTable() . " as wg",
                $this->warehouseGroupRepo->getPrimaryKey(),
                "=",
                "wh.warehouse_group_code")
                ->when( isset($filters['group_code']) , function($query) use ($filters){
                    return $query->where("wg.warehouse_group_code", $filters['group_code']);
                });
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("wg.warehouse_group_name")
            ->join($this->warehouseGroupRepo->getTable() . " as wg",
                $this->warehouseGroupRepo->getPrimaryKey(),
                "=",
                "wh.warehouse_group_code");
    }
}
