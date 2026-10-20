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

    public static function fromArray(array $data): static
    {
        return new static(
            series_name: (string) $data['series_name'],
            series_description: (string) $data['series_description'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
