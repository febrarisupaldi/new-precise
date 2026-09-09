<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\ProductAppearance\CreateProductAppearanceDTO;
use App\DTOs\Master\ProductAppearance\UpdateProductAppearanceDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ProductAppearance\CreateProductAppearanceRequest;
use App\Http\Requests\Master\ProductAppearance\UpdateProductAppearanceRequest;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;
use App\Services\Master\ProductAppearanceService;
use Dedoc\Scramble\Attributes\Get;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|Product Appearance', 'Product Appearance')]
class ProductAppearanceController extends Controller
{
    protected ProductAppearanceService $productAppearanceService;

    public function __construct(ProductAppearanceService $productAppearanceService)
    {
        $this->productAppearanceService = $productAppearanceService;
    }

    public function index(): JsonResponse
    {
        try {
            $data = $this->productAppearanceService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Appearance retrieved successfully',
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

    public function show(int $id): JsonResponse
    {
        try {
            $data = $this->productAppearanceService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Appearance retrieved successfully',
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

    public function store(CreateProductAppearanceRequest $request): JsonResponse
    {
        try {
            $dto = CreateProductAppearanceDTO::fromRequest($request);
            $this->productAppearanceService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Appearance created successfully.',
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

    public function update(int $id, UpdateProductAppearanceRequest $request): JsonResponse
    {
        try {
            $dto = UpdateProductAppearanceDTO::fromRequest($request);
            $this->productAppearanceService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Product Appearance updated successfully.',
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
