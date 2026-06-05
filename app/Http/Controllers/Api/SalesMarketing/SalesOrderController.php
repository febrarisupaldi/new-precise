<?php

namespace App\Http\Controllers\Api\SalesMarketing;

use App\Exceptions\BadRequestException;
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
            if($request->query('number') != null){
                $result = $this->salesOrderService->findBySalesNumber($request->query('number'));
            }else{
                $result = $this->salesOrderService->all(
                    $request->query('start', date("Y-m-01")),
                    $request->query('end', date("Y-m-t"))
                );
            }


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

    public function show(int $id): JsonResponse{
        try {
            $result = $this->salesOrderService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Sales order data retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: $e->getCode()
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SalesOrderController@show');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve sales order data.',
                code: 500
            );
        }
    }
}
