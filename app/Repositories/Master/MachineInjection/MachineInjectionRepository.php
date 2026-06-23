<?php

namespace App\Repositories\Master\MachineInjection;

use App\Repositories\BaseRepository;
use App\Repositories\Master\MachineStatus\MachineStatusRepository;
use Illuminate\Database\Query\Builder;

class MachineInjectionRepository extends BaseRepository
{

    private MachineStatusRepository $machineStatusRepo;
    protected string $table = 'precise.machine_injection'; 
    protected string $as = 'mi';
    protected string $primaryKey = 'mi.machine_injection_id';
    protected array $columns = [
        'mi.machine_injection_id',
        'mi.machine_code',
        'mi.old_machine_code',
        'mi.line_code',
        'mi.line_number',
        'mi.tonnage',
        'mi.serial_number',
        'mi.production_year',
        'mi.brand',
        'mi.motor_power',
        'mi.heater_power',
        'mi.machine_status_code',
        'mi.created_on',
        'mi.created_by',
        'mi.updated_on',
        'mi.updated_by'
    ];

    public function __construct(MachineStatusRepository $machineStatusRepo)
    {
        $this->machineStatusRepo = $machineStatusRepo;
    }

    public function all(?array $filters = []): Builder{
        return parent::all()->addSelect(
            "ms.status_description"
        )->join(
            $this->machineStatusRepo->table . ' as ' . $this->machineStatusRepo->as,
            'mi.machine_status_code',
            '=',
            $this->machineStatusRepo->primaryKey
        )->when($filters['code'] ?? null, function($query) use ($filters) {
            return $query->where('mi.machine_code', $filters['code']);
        });
    }
    // Add custom repository methods here
}
