<?php

namespace App\DTOs\Master\MoldMaking;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateMoldMakingDTO extends BaseDTO
{
    public function __construct(
        public readonly string $estimation_number,
        public readonly string $created_by
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            estimation_number: (string) $data['estimation_number'],
            created_by: (string) $data['created_by']
        );
    }
}
