<?php

namespace App\DTOs\Master\MachineInjection;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMachineInjectionDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here
    public function __construct(
        public readonly string $machine_code,
        public readonly ?string $old_machine_code,
        public readonly ?string $line_code,
        public readonly ?string $line_number,
        public readonly ?int $tonnage,
        public readonly ?string $serial_number,
        public readonly ?int $production_year,
        public readonly ?string $brand,
        public readonly ?float $motor_power,
        public readonly ?float $heater_power,
        public readonly ?string $machine_status_code,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            machine_code: (string) $data['machine_code'],
            old_machine_code: (string) $data['old_machine_code'],
            line_code: (string) $data['line_code'],
            line_number: (string) $data['line_number'],
            tonnage: (int) $data['tonnage'],
            serial_number: (string) $data['serial_number'],
            production_year: (int) $data['production_year'],
            brand: (string) $data['brand'],
            motor_power: (float) $data['motor_power'],
            heater_power: (float) $data['heater_power'],
            machine_status_code: (string) $data['machine_status_code'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
