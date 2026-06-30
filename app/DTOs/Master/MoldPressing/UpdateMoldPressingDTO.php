<?php

namespace App\DTOs\Master\MoldPressing;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateMoldPressingDTO extends BaseDTO
{

    use AuditDTO;
    // Define properties here
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
         $dto->updated_by = $request->input('updated_by');
 $dto->reason = $request->input('reason');

        return $dto;
    }
}
