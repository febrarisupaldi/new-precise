<?php

namespace App\DTOs\Master\AddressType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateAddressTypeDTO extends BaseDTO
{

    public function __construct(
        public readonly string $address_type_name,
        public readonly ?string $address_type_description,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            address_type_name: (string) $data['address_type_name'],
            address_type_description: (string) $data['address_type_description'] ?? null,
            created_by: (string) $data['created_by']
        );
    }
}
