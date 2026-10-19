<?php

namespace App\DTOs\Master\ProductSeries;

// php namespace
use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateProductSeriesDTO extends BaseDTO
{

    public function __construct(
        public readonly string $series_name,
        public readonly ?string $series_description,
        public readonly string $created_by
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new static(
            series_name: (string) $request->input('series_name'),
            series_description: (string) $request->input('series_description'),
            created_by: (string) $request->input('created_by')
        );
    }
}
