<?php

namespace App\DTOs\Engineering\MachinePressingActivity;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMachinePressingActivityDTO extends BaseDTO
{
    // Define properties here
     use AuditDTO;
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
