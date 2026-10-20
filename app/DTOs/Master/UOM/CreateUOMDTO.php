<?php

namespace App\DTOs\Master\UOM;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateUOMDTO extends BaseDTO
{
    public function __construct(
        public readonly string $uom_code,
        public readonly string $uom_name,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            uom_code: (string) $data['uom_code'],
            uom_name: (string) $data['uom_name'],
            is_active: (bool) $data['is_active'],
            created_by: (string) $data['created_by']
        );
    }
}
