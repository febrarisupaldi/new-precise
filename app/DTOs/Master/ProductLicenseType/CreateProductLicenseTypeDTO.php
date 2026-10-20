<?php

namespace App\DTOs\Master\ProductLicenseType;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductLicenseTypeDTO extends BaseDTO
{
    public function __construct(
        public readonly string $license_type_name,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            license_type_name: (string) $data['license_type_name'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
