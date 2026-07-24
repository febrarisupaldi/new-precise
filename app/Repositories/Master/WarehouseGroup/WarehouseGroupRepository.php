<?php

namespace App\Repositories\Master\WarehouseGroup;

use App\Repositories\BaseRepository;

class WarehouseGroupRepository extends BaseRepository
{
    protected string $table = 'precise.warehouse_group';
    protected string $as = 'wg';
    protected string $primaryKey = 'wg.warehouse_group_code';
    protected array $columns = [
        'wg.warehouse_group_code',
        'wg.warehouse_group_name',
        'wg.created_by',
        'wg.updated_by',
        'wg.created_on',
        'wg.updated_on',
    ];

    protected array $allowedExistsColumns = [
        ["warehouse_group_code"]
    ];

    // Add custom repository methods here
}
