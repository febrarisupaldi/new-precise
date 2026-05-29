<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\Warehouse\CreateWarehouseDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Warehouse\Warehouse\CreateWarehouseRequest;
use App\Services\Master\WarehouseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(): JsonResponse
    {
        try {
            $result = $this->warehouseService->all();

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
}
