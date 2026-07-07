<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductEquivalent\{CreateProductEquivalentDTO, UpdateProductEquivalentDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductEquivalent\{CreateProductEquivalentRequest, UpdateProductEquivalentRequest};
use App\Services\Master\ProductEquivalentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductEquivalentController extends Controller
{
    protected ProductEquivalentService $productEquivalentService;
    public function __construct(
        ProductEquivalentService $productEquivalentService
    ) {
        $this->productEquivalentService = $productEquivalentService;
    }

    /**
     * 
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

    public function check()
    {
        throw new \Exception('Not implemented');
    }
}
