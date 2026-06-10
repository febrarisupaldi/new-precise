<?php

namespace App\DTOs\Master\CustomerAddress;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCustomerAddressDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public int $customer_id;
    public int $address_type_id;
    public bool $is_default;
    public string $address;
    public ?string $subdistrict;
    public ?string $district;
    public ?int $city_id;
    public ?string $zipcode;
    public ?string $phone_number;
    public ?string $fax_number;
    public ?string $email;
    public ?string $website;
    public ?string $off_hour;
    public ?string $contact_person;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->customer_id = (int) $request->input('customer_id');
        $dto->address_type_id = (int) $request->input('address_type_id');
        $dto->is_default = (bool) $request->input('is_default');
        $dto->address = $request->input('address');
        $dto->subdistrict = $request->input('subdistrict');
        $dto->district = $request->input('district');
        $dto->city_id = (int) $request->input('city_id');
        $dto->zipcode = (int) $request->input('zipcode');
        $dto->phone_number = $request->input('phone_number');
        $dto->fax_number = $request->input('fax_number');
        $dto->email = $request->input('email');
        $dto->website = $request->input('website');
        $dto->off_hour = $request->input('off_hour');
        $dto->contact_person = $request->input('contact_person');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
