<?php

namespace App\Http\Controllers\Api\SalesMarketing;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesMarketing\SalesOrder\IndexSalesOrderRequest;
use App\Services\SalesMarketing\SalesOrderService;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\JsonResponse;

#[Group('Sales|Sales Order', 'Sales Orders')]
class SalesOrderController extends Controller
{
    protected SalesOrderService $salesOrderService;

    public function __construct(SalesOrderService $salesOrderService)
    {
        $this->salesOrderService = $salesOrderService;
    }

    #[QueryParameter("from", type: "string", description: "Start date.", example: "2022-01-01")]
    #[QueryParameter("to", type: "string", description: "End date.", example: "2022-01-01")]
    public function index(IndexSalesOrderRequest $request): JsonResponse
    {
        try {
            $result = $this->salesOrderService->all($request->validated());

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

    // public function show(int $id): JsonResponse
    // {
    //     try {
    //         $result = $this->salesOrderService->find($id);

    //         return $this->jsonResponse(
    //             status: 'ok',
    //             message: 'Sales order data retrieved successfully.',
    //             data: $result,
    //             code: 200
    //         );
    //     } catch (BadRequestException $e) {
    //         return $this->jsonResponse(
    //             status: 'error',
    //             message: $e->getMessage(),
    //             code: $e->getCode()
    //         );
    //     } catch (\Throwable $e) {
    //         $this->logError($e, 'SalesOrderController@show');

    //         return $this->jsonResponse(
    //             status: 'error',
    //             message: 'Failed to retrieve sales order data.',
    //             code: 500
    //         );
    //     }
    // }
}
