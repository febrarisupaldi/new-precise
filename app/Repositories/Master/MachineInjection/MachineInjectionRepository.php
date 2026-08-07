<?php

namespace App\Repositories\Master\MachineInjection;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class MachineInjectionRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'machine_injection');
    }

    public function all(?array $filters = []): Builder
    {
        $machineStatus = table('master', 'machine_status');

        $query = parent::all();

        JoinBuilder::leftJoin(
            $query,
            $machineStatus,
            $this->table->column("machine_status_code"),
            '=',
            $machineStatus->column("machine_status_code")
        );

        return $query->addSelect(
            $machineStatus->column("status_description")
        )->when($filters['code'] ?? null, function ($query) use ($filters) {
            return $query->where($this->table->column('machine_code'), $filters['code']);
        });
    }
    // Add custom repository methods here
}
