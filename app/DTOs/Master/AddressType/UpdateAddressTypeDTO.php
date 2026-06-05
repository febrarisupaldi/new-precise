<?php

namespace App\DTOs\Master\AddressType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateAddressTypeDTO extends BaseDTO
{
    use AuditDTO;

    public string $address_type_name;
    public ?string $address_type_description;
    public string $updated_by;
    public string $reason;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->address_type_name        = $request->input('address_type_name');
        $dto->address_type_description = $request->input('address_type_description');
        $dto->updated_by               = $request->input('updated_by');
        $dto->reason                   = $request->input('reason');
        return $dto;
    }
}
