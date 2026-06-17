<?php

namespace App\Repositories\Master\MachineStatus;

use App\Repositories\BaseRepository;

class MachineStatusRepository extends BaseRepository
{
    protected string $table = 'precise.machine_status'; 
    protected string $as = 'ms';
    protected string $primaryKey = 'ms.status_code';
    protected array $columns = [
        
    ];

    // Add custom repository methods here
}
