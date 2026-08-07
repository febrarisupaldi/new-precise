<?php

namespace App\Repositories\Master\MachineStatus;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class MachineStatusRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'machine_status');
    }
}
