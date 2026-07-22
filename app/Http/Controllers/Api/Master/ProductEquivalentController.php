<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductEquivalent\{CreateProductEquivalentDTO, UpdateProductEquivalentDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductEquivalent\{CreateProductEquivalentRequest, UpdateProductEquivalentRequest};
use App\Services\Master\ProductEquivalentService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Product Equivalent', 'Product Equivalents')]
class ProductEquivalentController extends Controller
{
    protected ProductEquivalentService $productEquivalentService;
    public function __construct(
        ProductEquivalentService $productEquivalentService
    ) {
        $this->productEquivalentService = $productEquivalentService;
    }

    /**
     * GET /api/master/product-equivalents
     *
     * Behavior:
     *  - get all product equivalents
     *
     * Query Parameters:
     *  - product_code optional, example: "A1"
     *
     * Authentication:
     *  - Requires valid bearer Token
     */
    public function index(Request $request): JsonResponse
    {
        try {
            if (!empty($request->query("product_code"))) {
                $result = $this->productEquivalentService->findByProductCode($request->query("product_code"));
            } else {
                $result = $this->productEquivalentService->all();
            }
            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductEquivalent list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductEquivalentController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductEquivalent list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/product-equivalents/{id}
     * 
     * Behavior:
     *  - get product equivalent by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->productEquivalentService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductEquivalent retrieved successfully.',
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
            $this->logError($e, 'ProductEquivalentController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve ProductEquivalent.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/product-equivalents
     * 
     * Behavior:
     *  - create product equivalent
     * 
     * Body:
     *  - product code required, example: "01.1.01.101.001"
     *  - uom code required, example: "KG"
     *  - qty std required, example: "1"
     *  - qty conversion required, example: 1000
     *  - updated by required, example: "hermanto"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param CreateProductEquivalentRequest $request
     * @return JsonResponse
     */
    public function store(CreateProductEquivalentRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductEquivalentDTO::fromRequest($request);
            $result = $this->productEquivalentService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductEquivalent created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ProductEquivalentController@store', $request->all());

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to store ProductEquivalent.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/product-equivalents/{id}
     * 
     * Behavior:
     *  - update product equivalent
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - product code optional, example: "01.1.01.101.001"
     *  - uom code optional, example: "KG"
     *  - qty std optional, example: "1"
     *  - qty conversion optional, example: 1000
     *  - updated by required, example: "hermanto"
     *  - reason required, example: "Updated description"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProductEquivalentRequest $request): JsonResponse
    {
        try {
            $dto = UpdateProductEquivalentDTO::fromRequest($request);
            $this->productEquivalentService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'ProductEquivalent updated successfully.',
                data: $dto->toArray(),
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
            $this->logError($th, 'ProductEquivalentController@update', $request->all());

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update ProductEquivalent.',
                code: 500
            );
        }
    }
}
