<?php

namespace App\DTOs\Master\MachineStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMachineStatusDTO extends BaseDTO
{
    public string $status_code;
    public string $status_description;
    public ?bool $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->status_code = $request->get('status_code');
        $dto->status_description = $request->get('status_description');
        $dto->is_active = $request->get('is_active');
        $dto->created_by = $request->get('created_by');
        return $dto;
    }
}
