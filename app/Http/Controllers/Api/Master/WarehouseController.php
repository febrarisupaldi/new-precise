<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\Warehouse\{CreateWarehouseDTO, UpdateWarehouseDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Warehouse\{CreateWarehouseRequest, UpdateWarehouseRequest};
use App\Services\Master\WarehouseService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Warehouse', 'Warehouses')]
class WarehouseController extends Controller
{
    protected WarehouseService $warehouseService;
    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    /**
     * GET /api/master/warehouses
     * 
     * Behavior:
     *  - get all warehouses
     * 
     * Query Parameters:
     *  - group_code optional, example: "1234"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->warehouseService->all($request->toArray());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'WarehouseController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve warehouse list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/warehouses/{id}
     * 
     * Behavior:
     *  - get warehouse by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->warehouseService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                id: $id,
                code: 404
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'WarehouseController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve warehouse.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/warehouses
     * 
     * Behavior:
     *  - create warehouse
     * 
     * Body:
     *  - warehouse code required, example: "WH1"
     *  - warehouse name required, example: "Warehouse 1"
     *  - warehouse alias optional, example: "Alias 1"
     *  - warehouse group code required, example: "1234"
     *  - is active optional, example: true
     *  - warehouse pic 1 optional, example: 2010123
     *  - warehouse pic 2 optional, example: 2010124
     *  - warehouse approver optional, example: 2010125
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param CreateWarehouseRequest $request
     * @return JsonResponse
     */
    public function store(CreateWarehouseRequest $request): JsonResponse
    {
        try {
            $dto = CreateWarehouseDTO::fromRequest($request);

            $result = $this->warehouseService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'WarehouseController@store');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create warehouse.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/warehouses/{id}
     * 
     * Behavior:
     *  - update warehouse
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - warehouse code optional, example: "WH1"
     *  - warehouse name optional, example: "Warehouse 1"
     *  - warehouse alias optional, example: "Alias 1"
     *  - warehouse group code optional, example: "1234"
     *  - is active optional, example: true
     *  - warehouse pic 1 optional, example: 2010123
     *  - warehouse pic 2 optional, example: 2010124
     *  - warehouse approver optional, example: 2010125
     *  - updated by required, example: "admin"
     *  - reason required, example: "test"
     * 
     * Authentication:
     *  - Requires valid bearer token
     *
     * @param int $id
     * @param UpdateWarehouseRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateWarehouseRequest $request): JsonResponse
    {
        try {
            $dto = UpdateWarehouseDTO::fromRequest($request);

            $this->warehouseService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse updated successfully.',
                data: $dto->toArray(),
                id: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'WarehouseController@update');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update warehouse.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/warehouses/{id}
     * 
     * Behavior:
     *  - delete warehouse
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - deleted by required, example: "admin"
     *  - reason required, example: "test"
     * 
     * Authentication:
     *  - Requires valid bearer token
     *
     * @param int $id
     * @param DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(int $id, DeleteRequest $request): JsonResponse
    {
        try {

            $this->warehouseService->delete($id, $request->toArray());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse deleted successfully.',
                data: $request->toArray(),
                id: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'WarehouseController@update');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update warehouse.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/warehouses/check
     * 
     * Behavior:
     *  - check if warehouse exists
     * 
     * Business Rules:
     *  - Columns and values must have the same length
     * 
     * Query Parameters:
     *  - columns[] required, example: "warehouse_code,warehouse_name"
     *  - values[] required, example: "WH1,Warehouse 1"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->warehouseService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Warehouse exists.',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check warehouse.',
                code: 500
            );
        }
    }
}
