<?php

namespace App\Http\Controllers\Api\SalesMarketing;

use App\Http\Controllers\Controller;
use App\Services\SalesMarketing\SalesOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalesOrderController extends Controller
{
    protected SalesOrderService $salesOrderService;

    public function __construct(SalesOrderService $salesOrderService)
    {
        $this->salesOrderService = $salesOrderService;
    }

    public function index(Request $request): JsonResponse{
        try {
            $result = $this->salesOrderService->all(
                $request->query('start', date("Y-m-01")),
                $request->query('end', date("Y-m-t"))
            );


            return $this->jsonResponse(
                status: 'ok',
                message: 'Sales order list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SalesOrderController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve sales order list.',
                code: 500
            );
        }
    }
}
