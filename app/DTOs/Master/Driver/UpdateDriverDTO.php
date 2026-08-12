<?php

namespace App\DTOs\Master\Driver;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateDriverDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public bool $is_active;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->is_active  = $request->input('is_active');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason     = $request->input('reason');

        return $dto;
    }
}
