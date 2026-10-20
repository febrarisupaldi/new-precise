<?php

namespace App\DTOs\PPIC\MaterialUsage;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateMaterialUsageDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }

    public static function fromArray(array $data): static
    {
        return new static(
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
