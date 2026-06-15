<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\Supplier\CreateSupplierDTO;
use App\DTOs\Master\Supplier\UpdateSupplierDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Supplier\CreateSupplierRequest;
use App\Http\Requests\Master\Supplier\UpdateSupplierRequest;
use App\Services\Master\SupplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    /**
     * GET /api/master/suppliers
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->supplierService->all($request->toArray());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Supplier list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SupplierController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve supplier list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/suppliers/{id}
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->supplierService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Supplier retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                id: $id,
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SupplierController@show');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve supplier.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/suppliers
     * @param CreateSupplierRequest $request
     * @return JsonResponse
     */
    public function store(CreateSupplierRequest $request): JsonResponse
    {
        try {
            $dto = CreateSupplierDTO::fromRequest($request);
            $id = $this->supplierService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Supplier created successfully.',
                data: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SupplierController@store');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create supplier.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/suppliers/{id}
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function update(int $id, UpdateSupplierRequest $request): JsonResponse
    {
        try {
            $dto = UpdateSupplierDTO::fromRequest($request);
            $this->supplierService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Supplier updated successfully.',
                data: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SupplierController@update');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update supplier.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/suppliers/check
     * @queryParam columns[] string required fields to check
     * @queryParam values[] string required values to check
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->supplierService->checkExist($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Supplier checked successfully.',
                data: ['exists' => $exists],
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SupplierController@check');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check supplier.',
                code: 500
            );
        }
    }
}
