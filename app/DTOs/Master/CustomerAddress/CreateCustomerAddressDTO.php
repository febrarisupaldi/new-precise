<?php

namespace App\DTOs\Master\CustomerAddress;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCustomerAddressDTO extends BaseDTO
{
    public function __construct(
        public int $customer_id,
        public int $address_type_id,
        public bool $is_default,
        public string $address,
        public ?string $subdistrict,
        public ?string $district,
        public ?int $city_id,
        public ?string $zipcode,
        public ?string $phone_number,
        public ?string $fax_number,
        public ?string $email,
        public ?string $website,
        public ?string $off_hour,
        public ?string $contact_person,
        public string $created_by,
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
            created_by: (string) $data['created_by'],
        );
    }
}
