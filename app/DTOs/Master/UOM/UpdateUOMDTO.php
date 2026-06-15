<?php

namespace App\DTOs\Master\UOM;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateUOMDTO extends BaseDTO
{
    use AuditDTO;
    // Define properties here
    public string $uom_code;
    public string $uom_name;
    public bool $is_active;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->uom_code = $request->input('uom_code');
        $dto->uom_name = $request->input('uom_name');
        $dto->is_active = (bool) $request->input('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
