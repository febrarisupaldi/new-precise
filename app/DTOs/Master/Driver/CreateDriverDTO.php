<?php

namespace App\DTOs\Master\Driver;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateDriverDTO extends BaseDTO
{
    public function __construct(
        public readonly ?bool $is_active,
        public readonly string $driver_nik,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            driver_nik: (string) $data['driver_nik'],
            created_by: (string) $data['created_by']
        );
    }
}
