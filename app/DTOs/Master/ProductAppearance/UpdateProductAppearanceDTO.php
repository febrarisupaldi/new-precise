<?php

namespace App\DTOs\Master\ProductAppearance;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductAppearanceDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public ?string $appearance_name;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->appearance_name = $request->input('appearance_name');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');
        return $dto;
    }
}
