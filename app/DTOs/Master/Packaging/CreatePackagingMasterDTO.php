<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreatePackagingMasterDTO extends BaseDTO
{
    // Define properties here
    // public $property;
    public int $packaging_id;
    public string $packaging_alias;
    public int $inner_length;
    public int $inner_width;
    public int $inner_height;
    public int $outer_length;
    public int $outer_width;
    public int $outer_height;
    public string $dimension_uom_code;
    public int $weight;
    public string $weight_uom_code;
    public string $packaging_spec;
    public int $max_stack;
    public int $is_active;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->packaging_id = (int) $request->input('packaging_id');
        $dto->packaging_alias = $request->input('packaging_alias');
        $dto->inner_length = (int) $request->input('inner_length');
        $dto->inner_width = (int) $request->input('inner_width');
        $dto->inner_height = (int) $request->input('inner_height');
        $dto->outer_length = (int) $request->input('outer_length');
        $dto->outer_width = (int) $request->input('outer_width');
        $dto->outer_height = (int) $request->input('outer_height');
        $dto->dimension_uom_code = $request->input('dimension_uom_code');
        $dto->weight = (int) $request->input('weight');
        $dto->weight_uom_code = $request->input('weight_uom_code');
        $dto->packaging_spec = $request->input('packaging_spec');
        $dto->max_stack = (int) $request->input('max_stack');
        $dto->is_active = (int) $request->input('is_active');
        $dto->created_by = $request->input("created_by");
        return $dto;
    }
}
