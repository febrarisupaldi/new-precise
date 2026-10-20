<?php

namespace App\DTOs\Master\RetailType;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateRetailTypeDTO extends BaseDTO
{
    // Define properties here
    public function __construct(
        public readonly string $retail_type_code,
        public readonly ?string $retail_type_description,
        public readonly string $groupcodeonproint,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            retail_type_code: (string) $data['retail_type_code'],
            retail_type_description: (string) $data['retail_type_description'],
            groupcodeonproint: (string) $data['groupcodeonproint'],
            created_by: (string) $data['created_by']
        );
    }
}
