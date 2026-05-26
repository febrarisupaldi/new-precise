<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\Packaging\CreatePackagingDTO;
use App\DTOs\Master\Packaging\UpdatePackagingDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Packaging\CreatePackagingRequest;
use App\Http\Requests\Master\Packaging\Packaging\UpdatePackagingRequest;
use App\Services\Master\PackagingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackagingController extends Controller
{

    protected PackagingService $packagingService;

    public function __construct(PackagingService $packagingService)
    {
        $this->packagingService = $packagingService;
    }

    /**
     * GET /api/master/packagings
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->packagingService->all($request->query('status'));


            return $this->jsonResponse(
                status: 'ok',
                message: 'Packaging list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'PackagingController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve packaging list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/packagings/{id}
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->packagingService->find($id);


            return $this->jsonResponse(
                status: 'ok',
                message: 'Packaging retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: "Data Not Found",
                data:[],
                code: 404
            );
        }catch (\Throwable $e) {
            $this->logError($e, 'PackagingController@show');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve packaging.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/packagings
     * @param CreatePackagingRequest $request
     * @return JsonResponse
     */
    public function store(CreatePackagingRequest $request): JsonResponse
    {
        try {
            $dto = CreatePackagingDTO::fromRequest($request);
            $this->packagingService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Packaging created successfully.',
                data: $dto->toArray(),
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'PackagingController@store');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create packaging.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/packagings/{id}
     * @routeParam {id} required
     * @param UpdatePackagingRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdatePackagingRequest $request): JsonResponse{
        try {
            $dto = UpdatePackagingDTO::fromRequest($request);
            $this->packagingService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Packaging updated successfully.',
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: "Data Not Found",
                data:[],
                code: 404
            );
        }catch (\Throwable $e) {
            $this->logError($e, 'PackagingController@update');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update packaging.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/packagings/check
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse{
        try {
            $dto = ExistsDTO::fromRequest($request);
            $result = $this->packagingService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Packaging checked successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'PackagingController@check');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check packaging.',
                code: 500
            );
        }
    }
}
