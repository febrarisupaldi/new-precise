<?php

namespace App\Http\Controllers\Api\Master;


use App\DTOs\Master\Packaging\{CreatePackagingDTO, UpdatePackagingDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Packaging\{CreatePackagingRequest, UpdatePackagingRequest};
use App\Services\Master\PackagingService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Packaging', 'Packagings')]
class PackagingController extends Controller
{

    protected PackagingService $packagingService;

    public function __construct(PackagingService $packagingService)
    {
        $this->packagingService = $packagingService;
    }

    /**
     * GET /api/master/packagings
     * 
     * Behavior:
     *  - No parameter: return all packagings.
     *  - `with=details`: return all packagings including details.
     *  - `status=1`: return only active packagings.
     *  - `status=0`: return only inactive packagings.
     *  
     * Query Parameters:
     *  - include optional, example: "details"
     *  - status optional, example: "active"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->packagingService->all($request->toArray());


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
     * 
     * Behavior:
     *  - return packagings data with id
     *  - if include details, return packaging data with details
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Query Parameters:
     *  - include optional, example: "details"
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
                data: [],
                code: 404
            );
        } catch (\Throwable $e) {
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
     * 
     * Behavior:
     *  - create new packaging
     * 
     * Body:
     *  - code: string
     *  - name: string
     *  - uom: string
     *  - status: int
     *  - description: string
     *  - created by: int
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
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
    public function update(int $id, UpdatePackagingRequest $request): JsonResponse
    {
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
                data: [],
                code: 404
            );
        } catch (\Throwable $e) {
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
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {

            $result = $this->packagingService->checkExist($request->query());

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
