<?php

namespace App\DTOs\Master\Country;

use App\DTOs\BaseDTO;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Http\Request;

class UpdateCountryDTO extends BaseDTO
{

    use AuditDTO;

    public function __construct(
        public readonly string $country_code,
        public readonly string $country_name,
        public readonly string $updated_by,
        public readonly string $reason
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            country_code: (string) $data['country_code'],
            country_name: (string) $data['country_name'],
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
