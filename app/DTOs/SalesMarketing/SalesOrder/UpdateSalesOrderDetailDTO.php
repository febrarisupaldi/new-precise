<?php

namespace App\DTOs\SalesMarketing\SalesOrder;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdateSalesOrderDetailDTO extends BaseDTO
{
    // Define properties here
     public string $updated_by;
 public string $reason;


    public static function fromRequest(Request $request)
    {
        $dto = new self();
         $dto->updated_by = $request->input('updated_by');
 $dto->reason = $request->input('reason');

        return $dto;
    }
}
