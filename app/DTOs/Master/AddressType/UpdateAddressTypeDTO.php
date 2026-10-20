<?php

namespace App\DTOs\Master\AddressType;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateAddressTypeDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $address_type_name,
        public readonly ?string $address_type_description,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            address_type_name: (string) $data['address_type_name'],
            address_type_description: (string) $data['address_type_description'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
