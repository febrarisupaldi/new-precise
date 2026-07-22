<?php

namespace App\DTOs\Master\Workcenter;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateWorkcenterDTO extends BaseDTO
{
    public string $workcenter_code;
    public string $workcenter_name;
    public ?string $workcenter_description;
    public ?int $default_warehouse;
    public ?string $production_type;
    public ?string $production_center;
    public ?int $subprocess_level;
    public ?bool $is_active;
    public int $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->workcenter_code = $request->input('workcenter_code');
        $dto->workcenter_name = $request->input('workcenter_name');
        $dto->workcenter_description = $request->input('workcenter_description');
        $dto->default_warehouse = (int) $request->input('default_warehouse');
        $dto->production_type = $request->input('production_type');
        $dto->production_center = $request->input('production_center');
        $dto->subprocess_level = (int) $request->input('subprocess_level');
        $dto->is_active = (bool) $request->input('is_active');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
