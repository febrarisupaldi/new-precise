<?php

namespace App\Repositories\Master\MachineInjection;

use App\Repositories\BaseRepository;

class MachineInjectionRepository extends BaseRepository
{
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

    // Add custom repository methods here
}
