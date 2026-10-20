<?php

namespace App\DTOs\Production\Melamine\MoldTransfer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldTransferDTO extends BaseDTO
{
    // Define properties here
    // public $property;



    public static function fromArray(array $data): static
    {
        return new static(
            // Define properties here
        );
    }
}
