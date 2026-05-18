<?php

namespace App\DTOs\Production\Melamine\MoldTransfer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMoldTransferDTO extends BaseDTO
{
    // Define properties here
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request)
    {
        $dto = new self();
        $dto->updated_by = $request->input('updated_by');
        $dto->reason     = $request->input('reason');

        return $dto;
    }
}
