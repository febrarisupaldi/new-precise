<?php

namespace App\DTOs\Master\CustomerAddress;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;

class UpdateCustomerAddressDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly int $customer_id,
        public readonly int $address_type_id,
        public readonly bool $is_default,
        public readonly string $address,
        public readonly ?string $subdistrict,
        public readonly ?string $district,
        public readonly ?int $city_id,
        public readonly ?string $zipcode,
        public readonly ?string $phone_number,
        public readonly ?string $fax_number,
        public readonly ?string $email,
        public readonly ?string $website,
        public readonly ?string $off_hour,
        public readonly ?string $contact_person,
        public readonly string $updated_by,
        public readonly string $reason,
    ) {}



    public static function fromArray(array $data): static
    {
        return new static(
            customer_id: (int) $data['customer_id'],
            address_type_id: (int) $data['address_type_id'],
            is_default: (bool) $data['is_default'],
            address: (string) $data['address'],
            subdistrict: (string) $data['subdistrict'] ?? null,
            district: (string) $data['district'] ?? null,
            city_id: (int) $data['city_id'] ?? null,
            zipcode: (string) $data['zipcode'] ?? null,
            phone_number: (string) $data['phone_number'] ?? null,
            fax_number: (string) $data['fax_number'] ?? null,
            email: (string) $data['email'] ?? null,
            website: (string) $data['website'] ?? null,
            off_hour: (string) $data['off_hour'] ?? null,
            contact_person: (string) $data['contact_person'] ?? null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason'],
        );
    }
}
