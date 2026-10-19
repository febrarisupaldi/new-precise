<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductVariant\{CreateProductVariantDTO, UpdateProductVariantDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\ProductVariant\{CreateProductVariantRequest, UpdateProductVariantRequest};
use App\Services\Master\ProductVariantService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Product Variant', 'Product Variant')]
class ProductVariantController extends Controller
{
    protected ProductVariantService $productVariantService;

    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }

    /**
     * GET /api/master/product-variants
     *
     * Behavior:
     *   - Return all productVariant data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->productVariantService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductVariant list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductVariantController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductVariant list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-variants/{id}
     *
     * Behavior:
     *   - Return single productVariant data based on id
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->productVariantService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductVariant retrieved successfully.',
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
            $this->logError($e, 'ProductVariantController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductVariant.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-variants
     *
     * Behavior:
     *   - Create single productVariant data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @param CreateProductVariantRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductVariantRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductVariantDTO::fromRequest($request);
            $result = $this->productVariantService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductVariant created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductVariantController@store',
                ['payload' => $request->all()]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create ProductVariant.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-variants/{id}
     *
     * Behavior:
     *   - Update single productVariant data based on id
     *
     * @routeParam {id} required
     * @param UpdateProductVariantRequest $request
     * @return JsonResponse
     */
    public function update(
        int $id,
        UpdateProductVariantRequest $request
    ): JsonResponse {
        try {
            $dto = UpdateProductVariantDTO::fromRequest($request);

            $this->productVariantService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductVariant updated successfully.',
                id: $id,
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductVariantController@update',
                [
                    'id' => $id,
                    'payload' => $request->all(),
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductVariant.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/product-variants/{id}
     *
     * Behavior:
     *   - Delete single productVariant data based on id
     *
     * @routeParam {id} required
     * @param DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(
        int $id,
        DeleteRequest $request
    ): JsonResponse {
        try {
            $this->productVariantService->delete(
                $id,
                $request->toArray()
            );

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductVariant deleted successfully.',
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
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductVariantController@delete'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete ProductVariant.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-variants/check
     *
     * Behavior:
     *   - Check if data already exists
     *
     * Query Parameters:
     *   - columns[] required
     *   - values[] required
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $exists = $this->productVariantService->checkExist(
                $request->query()
            );

            return $this->jsonResponse(
                status: 'ok',
                message: 'Check completed.',
                data: [
                    'exists' => $exists,
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductVariantController@check',
                ['query' => $request->query()]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
