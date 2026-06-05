<?php

namespace App\DTOs\Master\SteelType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateSteelTypeDTO extends BaseDTO
{
    use AuditDTO;

    public string $steel_type_name;
    public bool $is_active;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->steel_type_name = $request->input('steel_type_name');
        $dto->is_active        = $request->input('is_active');
        $dto->updated_by      = $request->input('updated_by');
        $dto->reason          = $request->input('reason');
        return $dto;
    }
}
