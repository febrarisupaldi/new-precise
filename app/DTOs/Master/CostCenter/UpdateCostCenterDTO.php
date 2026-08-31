<?php

namespace App\DTOs\Master\CostCenter;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateCostCenterDTO extends BaseDTO
{
    // Define properties here
    use AuditDTO;
    public string $cost_center_code;
    public string $cost_center_name;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->cost_center_code = $request->input('cost_center_code');
        $dto->cost_center_name = $request->input('cost_center_name');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
