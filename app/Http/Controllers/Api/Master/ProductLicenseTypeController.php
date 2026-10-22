<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductLicenseType\CreateProductLicenseTypeDTO;
use App\DTOs\Master\ProductLicenseType\UpdateProductLicenseTypeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductLicenseType\CreateProductLicenseTypeRequest;
use App\Http\Requests\Master\ProductLicenseType\UpdateProductLicenseTypeRequest;
use App\Services\Master\ProductLicenseTypeService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|Product License Type', 'Product License Type')]
class ProductLicenseTypeController extends Controller
{
    protected ProductLicenseTypeService $productLicenseTypeService;

    public function __construct(
        ProductLicenseTypeService $productLicenseTypeService
    ) {
        $this->productLicenseTypeService = $productLicenseTypeService;
    }

    public function index(): JsonResponse
    {
        try {
            $result = $this->productLicenseTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductLicenseType list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductLicenseTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductLicenseType list.',
                code: 500
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->productLicenseTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductLicenseType retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductLicenseTypeController@show');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductLicenseType.',
                code: 500
            );
        }
    }

    public function store(CreateProductLicenseTypeRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductLicenseTypeDTO::fromArray($request->validated());

            $result = $this->productLicenseTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductLicenseType created successfully.',
                data: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductLicenseTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create ProductLicenseType.',
                code: 500
            );
        }
    }

    public function update(UpdateProductLicenseTypeRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateProductLicenseTypeDTO::fromArray($request->validated());

            $this->productLicenseTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductLicenseType updated successfully.',
                data: $dto,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductLicenseTypeController@update');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductLicenseType.',
                code: 500
            );
        }
    }
}
