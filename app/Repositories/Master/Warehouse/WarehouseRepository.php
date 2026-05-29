<?php

namespace App\Repositories\Master\Warehouse;

use App\Repositories\BaseRepository;

class WarehouseRepository extends BaseRepository
{
    protected string $table = 'precise.warehouse'; 
    protected string $as = 'w';
    protected string $primaryKey = 'warehouse_id';
    protected array $columns = [
        'warehouse_id',
        'warehouse_code',
        'warehouse_name',
        'warehouse_alias',
        'warehouse_group_code',
        'is_active',
        'warehouse_pic_1',
        'warehouse_pic_2',
        'warehouse_approver',
        'created_on',
        'created_by',
        'updated_on',
        'updated_by'
    ];

    // Add custom repository methods here
}
