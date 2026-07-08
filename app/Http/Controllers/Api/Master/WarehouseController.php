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
     * Get all warehouses
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->warehouseService->all($request->query('group_code'));

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
     * Get warehouse by ID
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
     * Create a new warehouse
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
     * Update a warehouse
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
     * Delete a warehouse
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
     * Check if a warehouse exists
     * GET /check?columns[]=column1,column2&values[]=value1,value2
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
