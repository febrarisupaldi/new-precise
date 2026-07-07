<?php

namespace App\DTOs\Master\MachineInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMachineInjectionDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here

    public string $machine_code;
    public ?string $old_machine_code;
    public ?string $line_code;
    public ?string $line_number;
    public ?int $tonnage;
    public ?string $serial_number;
    public ?int $production_year;
    public ?string $brand;
    public ?float $motor_power;
    public ?float $heater_power;
    public ?string $machine_status_code;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->old_machine_code = $request->input('old_machine_code');
        $dto->machine_code = $request->input('machine_code');
        $dto->line_code = $request->input('line_code');
        $dto->line_number = $request->input('line_number');
        $dto->tonnage = (int)$request->input('tonnage');
        $dto->serial_number = $request->input('serial_number');
        $dto->production_year = (int)$request->input('production_year');
        $dto->brand = $request->input('brand');
        $dto->motor_power = (float)$request->input('motor_power');
        $dto->heater_power = (float)$request->input('heater_power');
        $dto->machine_status_code = $request->input('machine_status_code');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
