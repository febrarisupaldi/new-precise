<?php

namespace App\DTOs\Master\CoolingMethod;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCoolingMethodDTO extends BaseDTO
{
    public function __construct(
        public readonly string $cooling_method_name,
        public readonly ?string $cooling_method_description,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            cooling_method_name: (string) $data['cooling_method_name'],
            cooling_method_description: (string) $data['cooling_method_description'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            created_by: (string) $data['created_by']
        );
    }
}
