<?php

namespace App\DTOs\Master\ProductSeries;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductSeriesDTO extends BaseDTO
{
    use AuditDTO;
    public string $series_name;
    public ?string $series_description;
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->series_name = $request->input('series_name');
        $dto->series_description = $request->input('series_description');
        $dto->updated_by = $request->input('updated_by');
        $dto->reason = $request->input('reason');

        return $dto;
    }
}
