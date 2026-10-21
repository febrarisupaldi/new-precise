<?php

namespace App\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class DateRangeDTO extends BaseDTO
{

    public function __construct(
        public string $from,
        public string $to
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            from: (string) $data['from'],
            to: (string) $data['to']
        );
    }

    public static function fromRequest(Request $request): static
    {
        return static::fromArray([
            'from' => $request->input('from', date("Y-m-01")),
            'to' => $request->input('to', date("Y-m-d"))
        ]);
    }
}
