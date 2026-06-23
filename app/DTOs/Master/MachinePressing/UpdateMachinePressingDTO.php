<?php

namespace App\DTOs\Master\MachinePressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMachinePressingDTO extends BaseDTO
{
    public string $machine_code;
    public ?string $old_machine_code;
    public string $machine_location;
    public string $line_code;
    public ?int $line_number;
    public int $tonnage;
    public string $serial_number;
    public int $production_year;
    public string $brand;
    public float $motor_power;
    public float $heater_power;
    public ?bool $can_plain;
    public ?bool $can_print;
    public ?bool $can_mug;
    public ?bool $can_bico_lg;
    public ?bool $can_bico_material;
    public ?int $priority_rank;
    public ?string $machine_status_code;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->machine_code =        $request->input('machine_code');
        $dto->old_machine_code =    $request->input('old_machine_code');
        $dto->machine_location =    $request->input('machine_location');
        $dto->line_code =           $request->input('line_code');
        $dto->line_number =         (int)   $request->input('line_number');
        $dto->tonnage =             $request->input('tonnage');
        $dto->serial_number =       $request->input('serial_number');
        $dto->production_year =     (int)   $request->input('production_year');
        $dto->brand =               $request->input('brand');
        $dto->motor_power =         (float) $request->input('motor_power');
        $dto->heater_power =        (float) $request->input('heater_power');
        $dto->can_plain =           (bool)  $request->input('can_plain');
        $dto->can_print =           (bool)  $request->input('can_print');
        $dto->can_mug =             (bool)  $request->input('can_mug');
        $dto->can_bico_lg =         (bool)  $request->input('can_bico_lg');
        $dto->can_bico_material =   (bool)  $request->input('can_bico_material');
        $dto->priority_rank =       (int)   $request->input('priority_rank');
        $dto->machine_status_code = $request->input('machine_status_code');
        $dto->updated_by =          $request->input('updated_by');
        $dto->reason =              $request->input('reason');
        return $dto;
    }
}
