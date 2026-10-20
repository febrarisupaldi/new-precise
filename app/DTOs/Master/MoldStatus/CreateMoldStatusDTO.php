<?php

namespace App\DTOs\Master\MoldStatus;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldStatusDTO extends BaseDTO
{
    public function __construct(
        public readonly string $status_code,
        public readonly ?string $status_description,
        public readonly ?bool $is_active,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            status_code: (string) $data['status_code'],
            status_description: (string) $data['status_description'],
            is_active: (bool) $data['is_active'],
            created_by: (string) $data['created_by']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
