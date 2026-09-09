<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductGroup\CreateProductGroupDTO;
use App\DTOs\Master\ProductGroup\UpdateProductGroupDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductGroup\CreateProductGroupRequest;
use App\Http\Requests\Master\ProductGroup\UpdateProductGroupRequest;
use App\Services\Master\ProductGroupService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Product Group', 'Product Group')]
class ProductGroupController extends Controller
{
    private ProductGroupService $productGroupService;

    public function __construct(ProductGroupService $productGroupService)
    {
        $this->productGroupService = $productGroupService;
    }

    /**
     * GET /master/product-groups
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->productGroupService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Group fetched successfully.',
                data: $data,
                code: 200
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ProductGroupController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to fetch Product Group.',
                code: 500
            );
        }
    }

    /**
     * GET /master/product-groups/{id}
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->productGroupService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Group fetched successfully.',
                data: $data,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ProductGroupController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to fetch Product Group.',
                code: 500
            );
        }
    }

    public function create(CreateProductGroupRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductGroupDTO::fromRequest($request);
            $id = $this->productGroupService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Group created successfully.',
                data: $dto->toArray(),
                id: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ProductGroupController@create');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Product Group.',
                code: 500
            );
        }
    }

    public function update(int $id, UpdateProductGroupRequest $request): JsonResponse
    {
        try {
            $dto = UpdateProductGroupDTO::fromRequest($request);
            $this->productGroupService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Group updated successfully.',
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ProductGroupController@update', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Product Group.',
                code: 500
            );
        }
    }
}
