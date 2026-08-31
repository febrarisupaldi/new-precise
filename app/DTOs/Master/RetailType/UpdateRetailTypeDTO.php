<?php

namespace App\DTOs\Master\RetailType;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateRetailTypeDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public string $retail_type_code;
    public string $retail_type_description;
    public string $groupcodeonproint;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->retail_type_code = $request->input('retail_type_code');
        $dto->retail_type_description = $request->input('retail_type_description');
        $dto->groupcodeonproint = $request->input('groupcodeonproint');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
