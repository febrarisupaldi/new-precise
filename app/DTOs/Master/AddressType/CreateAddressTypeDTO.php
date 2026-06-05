<?php

namespace App\DTOs\Master\AddressType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateAddressTypeDTO extends BaseDTO
{
    public string $address_type_name;
    public ?string $address_type_description;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->address_type_name        = $request->input('address_type_name');
        $dto->address_type_description = $request->input('address_type_description');
        $dto->created_by               = $request->input('created_by');
        return $dto;
    }
}
