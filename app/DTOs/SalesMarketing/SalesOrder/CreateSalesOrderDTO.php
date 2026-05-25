<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class CreateSalesOrderDTO extends BaseDTO
{
    // Define properties here
     public CreateSalesOrderMasterDTO $master;

 /**
 * @var array<CreateSalesOrderDetailDTO>
 */
 public array $details = [];


    public static function fromRequest(Request $request)
    {
        $dto = new self();
        // $dto->property = $request->input('property');
        return $dto;
    }
}
