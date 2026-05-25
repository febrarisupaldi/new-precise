<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateSalesOrderDTO extends BaseDTO
{
    // Define properties here
     public UpdateSalesOrderMasterDTO $master;

 /**
 * @var array<UpdateSalesOrderDetailDTO>
 */
 public array $details = [];


    public static function fromRequest(Request $request)
    {
        $dto = new self();
        // $dto->property = $request->input('property');
        return $dto;
    }
}
