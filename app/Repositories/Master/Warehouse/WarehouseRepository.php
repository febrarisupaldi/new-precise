<?php

namespace App\Repositories\Master\Warehouse;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\WarehouseGroup\WarehouseGroupRepository;
use Illuminate\Database\Query\Builder;

class WarehouseRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "warehouse");
    }

    public function all(?array $filters = null): Builder
    {
        $warehouseGroup = table("precise", "warehouse_group");

        $query = parent::all();

        JoinBuilder::join(
            $query,
            $warehouseGroup,
            $this->table->column("warehouse_group_code"),
            "=",
            $warehouseGroup->pk(),
        );

        return $query
            ->addSelect($warehouseGroup->column("warehouse_group_name"))
            ->when($filters['group_code'] ?? null, function ($query) use ($filters) {
                return $query->where($this->table->column("warehouse_group_code"), $filters['group_code']);
            });
    }

    public function find(mixed $id): Builder
    {
        $warehouseGroup = table("precise", "warehouse_group");
        $query = parent::find($id);

        JoinBuilder::join(
            $query,
            $warehouseGroup,
            $this->table->column("warehouse_group_code"),
            "=",
            $warehouseGroup->pk(),
        );

        return $query->addSelect($warehouseGroup->column("warehouse_group_name"));
    }
}
