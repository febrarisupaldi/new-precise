<?php

namespace App\DTOs;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class DateRangeDTO extends BaseDTO
{
    public string $from;
    public string $to;

    public static function fromRequest(
        Request $request
    ): static {

        $dto = new static();

        $dto->from = $request->input('from', date("Y-m-01"));
        $dto->to = $request->input('to', date("Y-m-d"));

        return $dto;
    }
}
