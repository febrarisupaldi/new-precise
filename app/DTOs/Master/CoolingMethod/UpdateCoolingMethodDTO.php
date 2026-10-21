<?php

namespace App\DTOs\Master\CoolingMethod;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateCoolingMethodDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $cooling_method_name,
        public readonly ?string $cooling_method_description,
        public readonly ?bool $is_active,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromArray(array $data): static
    {
        return new static(
            cooling_method_name: (string) $data['cooling_method_name'],
            cooling_method_description: (string) $data['cooling_method_description'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
