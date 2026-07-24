<?php

namespace App\Repositories\Master\MachineStatus;

use App\Repositories\BaseRepository;

class MachineStatusRepository extends BaseRepository
{
    protected string $table = 'precise.machine_status';
    protected string $as = 'ms';
    protected string $primaryKey = 'ms.status_code';
    protected array $columns = [
        'ms.status_code',
        'ms.status_description',
        'ms.is_active',
        'ms.created_by',
        'ms.created_on',
        'ms.updated_by',
        'ms.updated_on'
    ];

    protected array $allowedExistsColumns = [
        ["status_code"]
    ];

    // Add custom repository methods here
}
