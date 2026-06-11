<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateWorkcenterDTO extends BaseDTO
{
    public string $workcenter_code;
    public string $workcenter_name;
    public ?string $workcenter_desc;
    public ?int $default_warehouse;
    public int $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->workcenter_code = $request->input('workcenter_code');
        $dto->workcenter_name = $request->input('workcenter_name');
        $dto->workcenter_desc = $request->input('workcenter_desc');
        $dto->default_warehouse = (int) $request->input('default_warehouse');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
