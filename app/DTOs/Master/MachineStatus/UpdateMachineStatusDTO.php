<?php

namespace App\DTOs\Master\MachineStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMachineStatusDTO extends BaseDTO
{
    use AuditDTO;
    public string $status_code;
    public string $status_description;
    public ?bool $is_active;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->status_code = $request->get('status_code');
        $dto->status_description = $request->get('status_description');
        $dto->is_active = $request->get('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
