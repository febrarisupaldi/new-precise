<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductSeries\{CreateProductSeriesDTO, UpdateProductSeriesDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\ProductSeries\{CreateProductSeriesRequest, UpdateProductSeriesRequest};
use App\Services\Master\ProductSeriesService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Product Series', 'Product Series')]
class ProductSeriesController extends Controller
{
    protected ProductSeriesService $productSeriesService;

    public function __construct(ProductSeriesService $productSeriesService)
    {
        $this->productSeriesService = $productSeriesService;
    }

    /**
     * GET /api/master/product-series
     *
     * Behavior:
     *   - Return all productSeries data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->productSeriesService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductSeries list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductSeriesController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductSeries list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-series/{id}
     *
     * Behavior:
     *   - Return single productSeries data based on id
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
            $result = $this->productSeriesService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductSeries retrieved successfully.',
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
            $this->logError($e, 'ProductSeriesController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductSeries.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-series
     *
     * Behavior:
     *   - Create single productSeries data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @param CreateProductSeriesRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductSeriesRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductSeriesDTO::fromRequest($request);
            $result = $this->productSeriesService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductSeries created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductSeriesController@store',
                ['payload' => $request->all()]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create ProductSeries.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-series/{id}
     *
     * Behavior:
     *   - Update single productSeries data based on id
     *
     * @routeParam {id} required
     * @param UpdateProductSeriesRequest $request
     * @return JsonResponse
     */
    public function update(
        int $id,
        UpdateProductSeriesRequest $request
    ): JsonResponse {
        try {
            $dto = UpdateProductSeriesDTO::fromRequest($request);

            $this->productSeriesService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductSeries updated successfully.',
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
                'ProductSeriesController@update',
                [
                    'id' => $id,
                    'payload' => $request->all(),
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductSeries.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/product-series/{id}
     *
     * Behavior:
     *   - Delete single productSeries data based on id
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
            $this->productSeriesService->delete(
                $id,
                $request->toArray()
            );

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductSeries deleted successfully.',
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
                'ProductSeriesController@delete'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete ProductSeries.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-series/check
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
            $exists = $this->productSeriesService->checkExist(
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
                'ProductSeriesController@check',
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
