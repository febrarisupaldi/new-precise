<?php

namespace App\DTOs\Master\ProductSeries;


use App\DTOs\Traits\AuditDTO;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateProductSeriesDTO extends BaseDTO
{
    use AuditDTO;

    public function __construct(
        public readonly string $series_name,
        public readonly ?string $series_description,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}


    public static function fromRequest(Request $request): static
    {
        return new static(
            series_name: (string) $request->input('series_name'),
            series_description: (string) $request->input('series_description'),
            updated_by: (string) $request->input('updated_by'),
            reason: (string) $request->input('reason')
        );
    }
}
