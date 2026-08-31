<?php

namespace App\Http\Requests\SalesMarketing\SalesOrder;

use App\Http\Requests\DateRangeRequest;

class IndexSalesOrderRequest extends DateRangeRequest
{
    public function rules(): array
    {
        return
            array_merge(
                parent::rules(),
                [
                    'number' => ['nullable', 'string', 'prohibits:from,to']
                ]
            );
    }
}
