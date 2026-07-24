<?php

namespace App\Repositories\Master\UOM;

use App\Repositories\BaseRepository;

class UOMRepository extends BaseRepository
{
    protected string $table = 'precise.uom';
    protected string $as = 'u';
    protected string $primaryKey = 'u.uom_code';
    protected array $columns = [
        'u.uom_code',
        'u.uom_name',
        'u.is_active',
        'u.created_by',
        'u.created_on',
        'u.updated_by',
        'u.updated_on'
    ];

    protected array $allowedExistsColumns = [
        ["uom_code"],
        ["uom_name"]
    ];

    // Add custom repository methods here
}
