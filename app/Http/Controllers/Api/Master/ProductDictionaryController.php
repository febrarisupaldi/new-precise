<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductDictionary\{CreateProductDictionaryDTO, UpdateProductDictionaryDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\ProductDictionary\{CreateProductDictionaryRequest, UpdateProductDictionaryRequest};
use App\Services\Master\ProductDictionaryService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Group('MASTER|Product Dictionary', 'Product Dictionaries')]
class ProductDictionaryController extends Controller
{
    protected ProductDictionaryService $productDictionaryService;

    public function __construct(ProductDictionaryService $productDictionaryService)
    {
        $this->productDictionaryService = $productDictionaryService;
    }

    /**
     * GET /api/master/product-dictionaries
     *
     * Behavior:
     *   - Return all productDictionary data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @return StreamedResponse
     */
    public function index(): StreamedResponse
    {
        try {
            return $this->streamJsonResponse(
                function (&$first) {

                    $this->productDictionaryService->all(
                        function ($row) use (&$first) {

                            if (!$first) {
                                echo ',';
                            }

                            echo json_encode($row);

                            $first = false;
                            flush();
                        }
                    );
                },
                'ProductDictionary list retrieved successfully.'
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductDictionaryController@index');

            return $this->streamJsonResponse(
                function () {},
                'Failed to retrieve ProductDictionary list.'
            );
        }
    }

    /**
     * GET /api/master/product-dictionaries/{id}
     *
     * Behavior:
     *   - Return single productDictionary data based on id
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
            $result = $this->productDictionaryService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductDictionary retrieved successfully.',
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
            $this->logError($e, 'ProductDictionaryController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductDictionary.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-dictionaries
     *
     * Behavior:
     *   - Create single productDictionary data
     *
     * Authentication:
     *   - Requires valid bearer Token
     *
     * @param CreateProductDictionaryRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductDictionaryRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductDictionaryDTO::fromRequest($request);
            $result = $this->productDictionaryService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductDictionary created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'ProductDictionaryController@store',
                ['payload' => $request->all()]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create ProductDictionary.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-dictionaries/{id}
     *
     * Behavior:
     *   - Update single productDictionary data based on id
     *
     * @routeParam {id} required
     * @param UpdateProductDictionaryRequest $request
     * @return JsonResponse
     */
    public function update(
        int $id,
        UpdateProductDictionaryRequest $request
    ): JsonResponse {
        try {
            $dto = UpdateProductDictionaryDTO::fromRequest($request);

            $this->productDictionaryService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductDictionary updated successfully.',
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
                'ProductDictionaryController@update',
                [
                    'id' => $id,
                    'payload' => $request->all(),
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductDictionary.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/product-dictionaries/{id}
     *
     * Behavior:
     *   - Delete single productDictionary data based on id
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
            $this->productDictionaryService->delete(
                $id,
                $request->toArray()
            );

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductDictionary deleted successfully.',
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
                'ProductDictionaryController@delete'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete ProductDictionary.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-dictionaries/check
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
            $exists = $this->productDictionaryService->checkExist(
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
                'ProductDictionaryController@check',
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
