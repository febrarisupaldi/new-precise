<?php

namespace App\DTOs\Master\ColorType;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateColorTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $color_type_code,
        public readonly string $color_type_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            color_type_code: (string) $data['color_type_code'],
            color_type_name: (string) $data['color_type_name'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
