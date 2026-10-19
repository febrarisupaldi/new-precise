<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductItem\{CreateProductItemDTO, UpdateProductItemDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\ProductItem\{CreateProductItemRequest, UpdateProductItemRequest};
use App\Services\Master\ProductItemService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Product Item', 'Product Item')]
class ProductItemController extends Controller
{
    protected ProductItemService $productItemService;

    public function __construct(ProductItemService $productItemService)
    {
        $this->productItemService = $productItemService;
    }

    /**
     * GET /api/master/product-items
     *
     * Behavior:
     *   - Return all productItem data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->productItemService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductItem list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductItemController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductItem list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-items/{id}
     *
     * Behavior:
     *   - Return single productItem data based on id
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
            $result = $this->productItemService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductItem retrieved successfully.',
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
            $this->logError($e, 'ProductItemController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductItem.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-items
     *
     * Behavior:
     *   - Create single productItem data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @param CreateProductItemRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductItemRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductItemDTO::fromRequest($request);
            $result = $this->productItemService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductItem created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductItemController@store',
                ['payload' => $request->all()]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create ProductItem.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-items/{id}
     *
     * Behavior:
     *   - Update single productItem data based on id
     *
     * @routeParam {id} required
     * @param UpdateProductItemRequest $request
     * @return JsonResponse
     */
    public function update(
        int $id,
        UpdateProductItemRequest $request
    ): JsonResponse {
        try {
            $dto = UpdateProductItemDTO::fromRequest($request);

            $this->productItemService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductItem updated successfully.',
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
                'ProductItemController@update',
                [
                    'id' => $id,
                    'payload' => $request->all(),
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductItem.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/product-items/{id}
     *
     * Behavior:
     *   - Delete single productItem data based on id
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
            $this->productItemService->delete(
                $id,
                $request->toArray()
            );

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductItem deleted successfully.',
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
                'ProductItemController@delete'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete ProductItem.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-items/check
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
            $exists = $this->productItemService->checkExist(
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
                'ProductItemController@check',
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
