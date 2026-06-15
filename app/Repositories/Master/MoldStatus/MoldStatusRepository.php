<?php

namespace App\Repositories\Master\MoldStatus;

use App\Repositories\BaseRepository;

class MoldStatusRepository extends BaseRepository
{
    protected string $table = 'precise.mold_status'; 
    protected string $as = 'ms';
    protected string $primaryKey = 'ms.status_code';
    protected array $columns = [
        'ms.status_code',
        'ms.status_description',
        'ms.is_active',
        'ms.created_on',
        'ms.created_by',
        'ms.updated_on',
        'ms.updated_by'
    ];

    // Add custom repository methods here
}
