<?php

namespace App\DTOs\Master\MachinePressing;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMachinePressingDTO extends BaseDTO
{
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
