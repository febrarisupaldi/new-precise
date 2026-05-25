<?php

namespace App\DTOs\Master\Packaging;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdatePackagingMasterDTO extends BaseDTO
{
    use AuditDTO;
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
    public string $updated_by;
    public string $reason;

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
        $dto->updated_by = $request->input("updated_by");
        $dto->reason = $request->input("reason");
        return $dto;
    }
}
