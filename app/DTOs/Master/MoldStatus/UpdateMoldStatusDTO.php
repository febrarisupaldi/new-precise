<?php

namespace App\DTOs\Master\MoldStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateMoldStatusDTO extends BaseDTO
{
    use AuditDTO;
    public string $status_code;
    public string $status_description;
    public bool $is_active;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->status_code = $request->input('status_code');
        $dto->status_description = $request->input('status_description');
        $dto->is_active = $request->input('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
