<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductType\CreateProductTypeDTO;
use App\DTOs\Master\ProductType\UpdateProductTypeDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductType\CreateProductTypeRequest;
use App\Http\Requests\Master\ProductType\UpdateProductTypeRequest;
use App\Services\Master\ProductTypeService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;


#[Group('MASTER|Product Type', 'Product Type')]
class ProductTypeController extends Controller
{
    protected ProductTypeService $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        $this->productTypeService = $productTypeService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->productTypeService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Type list retrieved successfully.',
                data: $data,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Product Type list.',
                code: 500
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->productTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Type retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Product Type.',
                code: 500
            );
        }
    }

    public function create(CreateProductTypeRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductTypeDTO::fromRequest($request);
            $id = $this->productTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Type created successfully.',
                data: $dto->toArray(),
                id: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductTypeController@create', $request->all());

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Product Type.',
                code: 500
            );
        }
    }

    public function update(int $id, UpdateProductTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateProductTypeDTO::fromRequest($request);
            $this->productTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Type updated successfully.',
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductTypeController@update', $request->all());

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Product Type.',
                code: 500
            );
        }
    }
}
