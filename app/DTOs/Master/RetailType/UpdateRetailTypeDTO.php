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


    public static function fromRequest(Request $request): static
    {
        return new static(
            retail_type_code: (string) $request->input('retail_type_code'),
            retail_type_description: (string) $request->input('retail_type_description'),
            groupcodeonproint: (string) $request->input('groupcodeonproint'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );

        return $dto;
    }
}
