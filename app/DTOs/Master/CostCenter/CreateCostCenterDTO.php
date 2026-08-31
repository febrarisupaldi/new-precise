<?php

namespace App\DTOs\Master\CostCenter;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateCostCenterDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public string $cost_center_code;
    public string $cost_center_name;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->cost_center_code = $request->input('cost_center_code');
        $dto->cost_center_name = $request->input('cost_center_name');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
