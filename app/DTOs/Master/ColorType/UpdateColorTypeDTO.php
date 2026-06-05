<?php

namespace App\DTOs\Master\ColorType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateColorTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public string $color_type_code;
    public string $color_type_name;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->color_type_code = $request->input('color_type_code');
        $dto->color_type_name = $request->input('color_type_name');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');
        return $dto;
    }
}
