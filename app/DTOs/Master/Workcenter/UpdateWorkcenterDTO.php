<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;
use App\DTOs\Traits\AuditDTO;

class UpdateWorkcenterDTO extends BaseDTO
{
    // Define properties here

    use AuditDTO;
    public string $workcenter_code;
    public string $workcenter_name;
    public ?string $workcenter_desc;
    public ?int $default_warehouse;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->workcenter_code = $request->input('workcenter_code');
        $dto->workcenter_name = $request->input('workcenter_name');
        $dto->workcenter_desc = $request->input('workcenter_desc');
        $dto->default_warehouse = (int) $request->input('default_warehouse');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
