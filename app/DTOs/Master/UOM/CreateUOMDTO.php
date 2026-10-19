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

    public static function fromRequest(Request $request): static
    {
        return new static(
            uom_code: (string) $request->input('uom_code'),
            uom_name: (string) $request->input('uom_name'),
            is_active: (bool) $request->input('is_active') ?? true,
            created_by: (string) $request->input('created_by')
        );
    }
}
