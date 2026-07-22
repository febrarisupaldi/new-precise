<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductBrand\CreateProductBrandDTO;
use App\DTOs\Master\ProductBrand\UpdateProductBrandDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductBrand\CreateProductBrandRequest;
use App\Http\Requests\Master\ProductBrand\UpdateProductBrandRequest;
use App\Services\Master\ProductBrandService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|Product Brand', 'Product Brands')]
class ProductBrandController extends Controller
{
    private ProductBrandService $productBrandService;
    public function __construct(ProductBrandService $productBrandService)
    {
        $this->productBrandService = $productBrandService;
    }

    /**
     * GET /api/master/product-brands
     * 
     * Behavior:
     *  - get all product brands
     * 
     * Authentication:
     *  - Requires valid bearer Token
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->productBrandService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Brand retrieved successfully',
                data: $data,
                code: 200
            );
        } catch (\Exception $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-brands/{id}
     * 
     * Behavior:
     *  - get product brand by id
     * 
     * Authentication:
     *  - Requires valid bearer Token
     *
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->productBrandService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Brand retrieved successfully',
                data: $data,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: "Data Not Found",
                data: [],
                code: 404
            );
        } catch (\Exception $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-brands
     * 
     * Behavior:
     *  - create product brand
     * 
     * Body:
     *  - product brand name required, example: "Brand Name"
     *  - is active required, example: true
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     *
     * @param  CreateProductBrandRequest  $request
     * @return JsonResponse
     */
    public function store(CreateProductBrandRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductBrandDTO::fromRequest($request);
            $this->productBrandService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Brand created successfully.',
                data: $dto->toArray(),
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: "Data Not Found",
                data: [],
                code: 404
            );
        } catch (\Exception $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-brands/{id}
     * 
     * Behavior:
     *  - update product brand
     * 
     * Body:
     *  - product brand name required, example: "Brand Name"
     *  - is active required, example: true
     *  - updated by required, example: "admin"
     *  - reason required, example: "Testing"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     *
     * @routeParam {id} required
     * @param  UpdateProductBrandRequest  $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProductBrandRequest $request): JsonResponse
    {
        try {
            $dto = UpdateProductBrandDTO::fromRequest($request);
            $this->productBrandService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Brand updated successfully.',
                data: $dto->toArray(),
                code: 200
            );
        } catch (\Throwable $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 500
            );
        }
    }
}
