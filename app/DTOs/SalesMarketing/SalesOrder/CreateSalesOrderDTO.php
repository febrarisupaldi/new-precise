<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSalesOrderDTO extends BaseDTO
{
    public function __construct() {}



    public static function fromArray(array $data): static
    {
        return new static(
            // Define properties here
        );
    }
}
