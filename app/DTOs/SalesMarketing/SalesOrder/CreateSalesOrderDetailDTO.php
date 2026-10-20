<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSalesOrderDetailDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }

    public static function fromArray(array $data): static
    {
        return new static(
            // Define properties here
        );
    }
}
