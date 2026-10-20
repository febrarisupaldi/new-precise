<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateSalesOrderDTO extends BaseDTO
{
    // Define properties here
    //  public UpdateSalesOrderMasterDTO $master;

    // /**
    // * @var array<UpdateSalesOrderDetailDTO>
    // */
    // public array $details = [];

    public function __construct() {}

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
