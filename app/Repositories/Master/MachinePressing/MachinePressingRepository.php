<?php

namespace App\Repositories\Master\MachinePressing;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\MachineStatus\MachineStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MachinePressingRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'machine_pressing');
    }

    public function all(?array $filters = []): Builder
    {
        $this->table->except(['can_plain', 'can_print', 'can_mug', 'can_bico_lg', 'can_bico_material']);

        $query = parent::all();

        $machineStatus = table('master', 'machine_status');

        JoinBuilder::leftJoin(
            $query,
            $machineStatus,
            $this->table->column('machine_status_code'),
            '=',
            $machineStatus->column('machine_status_code')
        );

        return $query->addSelect(
            $machineStatus->column('status_description'),
            DB::raw("
                case when {$this->table->column('can_plain')} = 1 then 'Ya' else 'Tidak' end as can_plain,  
                case when {$this->table->column('can_print')} = 1 then 'Ya' else 'Tidak' end as can_print,  
                case when {$this->table->column('can_mug')} = 1 then 'Ya' else 'Tidak' end as can_mug,  
                case when {$this->table->column('can_bico_lg')} = 1 then 'Ya' else 'Tidak' end as can_bico_lg, 
                case when {$this->table->column('can_bico_material')} = 1 then 'Ya' else 'Tidak' end as can_bico_material 
            ")
        )->when($filters['code'] ?? null, function ($query) use ($filters) {
            return $query->where($this->table->column('machine_code'), $filters['code']);
        })
            ->when(
                $filters['old_code'] ?? null && $filters['location'] ?? null,
                function ($query) use ($filters) {
                    return $query->where($this->table->column('old_machine_code'), $filters['old_machine_code'])
                        ->where($this->table->column('machine_location'), $filters['machine_location']);
                }
            );;
    }
    // Add custom repository methods here
}
