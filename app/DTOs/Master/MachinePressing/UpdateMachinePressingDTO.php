<?php

namespace App\DTOs\Master\MachinePressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMachinePressingDTO extends BaseDTO
{
    use AuditDTO;
    public function __construct(
        public readonly string $machine_code,
        public readonly ?string $old_machine_code,
        public readonly string $machine_location,
        public readonly string $line_code,
        public readonly ?int $line_number,
        public readonly int $tonnage,
        public readonly string $serial_number,
        public readonly int $production_year,
        public readonly string $brand,
        public readonly float $motor_power,
        public readonly float $heater_power,
        public readonly ?bool $can_plain,
        public readonly ?bool $can_print,
        public readonly ?bool $can_mug,
        public readonly ?bool $can_bico_lg,
        public readonly ?bool $can_bico_material,
        public readonly ?int $priority_rank,
        public readonly ?string $machine_status_code,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            machine_code: (string) $data['machine_code'],
            old_machine_code: (string) $data['old_machine_code'] ?? null,
            machine_location: (string) $data['machine_location'],
            line_code: (string) $data['line_code'],
            line_number: (int) $data['line_number'] ?? null,
            tonnage: (int) $data['tonnage'],
            serial_number: (string) $data['serial_number'],
            production_year: (int) $data['production_year'],
            brand: (string) $data['brand'],
            motor_power: (float) $data['motor_power'],
            heater_power: (float) $data['heater_power'],
            can_plain: (bool) $data['can_plain'] ?? null,
            can_print: (bool) $data['can_print'] ?? null,
            can_mug: (bool) $data['can_mug'] ?? null,
            can_bico_lg: (bool) $data['can_bico_lg'] ?? null,
            can_bico_material: (bool) $data['can_bico_material'] ?? null,
            priority_rank: (int) $data['priority_rank'] ?? null,
            machine_status_code: (string) $data['machine_status_code'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
