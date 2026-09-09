<?php

namespace App\DTOs\Master\ProductSeries;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductSeriesDTO extends BaseDTO
{
    public string $series_name;
    public ?string $series_description;
    public string $created_by;

    public static function fromRequest(Request $request): static
    {
        $dto = new self();
        $dto->series_name = $request->input('series_name');
        $dto->series_description = $request->input('series_description');
        $dto->created_by = $request->input('created_by');
        return $dto;
    }
}
