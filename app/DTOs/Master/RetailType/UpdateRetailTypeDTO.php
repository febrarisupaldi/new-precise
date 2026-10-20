<?php

namespace App\DTOs\Master\RetailType;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateRetailTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;

    public function __construct(
        public readonly string $retail_type_code,
        public readonly string $retail_type_description,
        public readonly string $groupcodeonproint,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            retail_type_code: (string) $data['retail_type_code'],
            retail_type_description: (string) $data['retail_type_description'],
            groupcodeonproint: (string) $data['groupcodeonproint'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }
}
