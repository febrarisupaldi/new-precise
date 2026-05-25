<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSalesOrderDetailDTO extends BaseDTO
{
    // Define properties here
    // public $property;

    public static function fromRequest(Request $request)
    {
        $dto = new self();
        // $dto->property = $request->input('property');
        return $dto;
    }
}
