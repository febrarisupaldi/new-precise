<?php

namespace App\DTOs\Production\Melamine\MoldTransfer;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMoldTransferDTO extends BaseDTO
{
    // Define properties here
    public string $updated_by;
    public string $reason;




    public static function fromArray(array $data): static
    {
        return new static(
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
