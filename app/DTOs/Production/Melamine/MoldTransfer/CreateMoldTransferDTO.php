<?php

namespace App\DTOs\Production\Melamine\MoldTransfer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldTransferDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public static function fromRequest(Request $request)
    {
        $dto = new self();
        // $dto->property = $request->input('property');
        return $dto;
    }
}
