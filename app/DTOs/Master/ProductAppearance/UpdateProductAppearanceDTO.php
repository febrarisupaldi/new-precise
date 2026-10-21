<?php

namespace App\DTOs\Master\ProductAppearance;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductAppearanceDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $appearance_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            appearance_name: (string) $data['appearance_name'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
