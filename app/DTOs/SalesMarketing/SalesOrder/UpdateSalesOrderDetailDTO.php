<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateSalesOrderDetailDTO extends BaseDTO
{
    // Define properties here
    public string $updated_by;
    public string $reason;


    public static function fromRequest(Request $request): static
    {
        return static::fromArray($request->validated());
    }

    public static function fromArray(array $data): static
    {
        return new static(
            updated_by: (string) $data['updated_by'],
            reason: (string) $data['reason']
        );
    }
}
