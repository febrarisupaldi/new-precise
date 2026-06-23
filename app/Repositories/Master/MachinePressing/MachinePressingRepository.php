<?php

namespace App\Repositories\Master\MachinePressing;

use App\Repositories\BaseRepository;
use App\Repositories\Master\MachineStatus\MachineStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MachinePressingRepository extends BaseRepository
{
    private MachineStatusRepository $machineStatusRepo;

    protected string $table = 'precise.machine_pressing'; 
    protected string $as = 'mp';
    protected string $primaryKey = 'mp.machine_pressing_id';
    protected array $columns = [
        'mp.machine_pressing_id',
        'mp.machine_code',
        'mp.old_machine_code',
        'mp.machine_location',
        'mp.line_code',
        'mp.line_number',
        'mp.tonnage',
        'mp.serial_number',
        'mp.production_year',
        'mp.brand',
        'mp.motor_power',
        'mp.heater_power',
        'mp.can_plain',
        'mp.can_print',
        'mp.can_mug',
        'mp.can_bico_lg',
        'mp.can_bico_material',
        'mp.priority_rank',
        'mp.machine_status_code',
        'mp.created_on',
        'mp.created_by',
        'mp.updated_on',
        'mp.updated_by'  
    ];

    public function __construct(MachineStatusRepository $machineStatusRepo)
    {
        $this->machineStatusRepo = $machineStatusRepo;
    }

    public function all(?array $filters = []): Builder{
        $this->removeColumn(['mp.can_plain', 'mp.can_print', 'mp.can_mug', 'mp.can_bico_lg', 'mp.can_bico_material']);
        return parent::all()->addSelect(
            "ms.status_description",
            DB::raw("
                case when mp.can_plain = 1 then 'Ya' else 'Tidak' end as can_plain,  
                case when mp.can_print = 1 then 'Ya' else 'Tidak' end as can_print,  
                case when mp.can_mug = 1 then 'Ya' else 'Tidak' end as can_mug,  
                case when mp.can_bico_lg = 1 then 'Ya' else 'Tidak' end as can_bico_lg, 
                case when mp.can_bico_material = 1 then 'Ya' else 'Tidak' end as can_bico_material 
            ")
        )->join(
            $this->machineStatusRepo->table . ' as ' . $this->machineStatusRepo->as,
            'mp.machine_status_code',
            '=',
            $this->machineStatusRepo->primaryKey
        )->when($filters['code'] ?? null, function($query) use ($filters) {
            return $query->where('mi.machine_code', $filters['code']);
        });
    }
    // Add custom repository methods here
}
