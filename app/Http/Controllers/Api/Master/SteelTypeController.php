<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\SteelTypeService;
use App\DTOs\Master\SteelType\{CreateSteelTypeDTO, UpdateSteelTypeDTO};
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\SteelType\{CreateSteelTypeRequest, UpdateSteelTypeRequest};
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Steel Type', 'Steel Types')]
class SteelTypeController extends Controller
{
    protected SteelTypeService $steelTypeService;

    public function __construct(SteelTypeService $steelTypeService)
    {
        $this->steelTypeService = $steelTypeService;
    }

    /**
     * GET /api/master/steel-types
     * 
     * Behavior:
     *  - get all steel types
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->steelTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Steel Type list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SteelTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Steel Type list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/steel-types/{id}
     * 
     * Behavior:
     *  - get steel type by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->steelTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Steel Type retrieved successfully.',
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
            $this->logError($e, 'SteelTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Steel Type.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/steel-types
     * 
     * Behavior:
     *  - create steel type
     * 
     * Body:
     *  - steel type name required, example: "Steel Type"
     *  - is active optional, example: true
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param CreateSteelTypeRequest $request
     * @return JsonResponse
     */
    public function store(CreateSteelTypeRequest $request): JsonResponse
    {
        try {
            $dto    = CreateSteelTypeDTO::fromRequest($request);
            $result = $this->steelTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Steel Type created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SteelTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Steel Type.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/steel-types/{id}
     * 
     * Behavior:
     *  - update steel type
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - steel type name optional, example: "Steel Type"
     *  - is active optional, example: true
     *  - updated by required, example: "admin"
     *  - reason required, example: "Updated description"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @routeParam {id} required
     * @param UpdateSteelTypeRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateSteelTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateSteelTypeDTO::fromRequest($request);
            $this->steelTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Steel Type updated successfully.",
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
            $this->logError($e, 'SteelTypeController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Steel Type.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/steel-types/check
     * 
     * Behavior:
     *  - check if steel type exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["name"]
     *  - values[] required, example: ["Steel Type"]
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);

            $exists = $this->steelTypeService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'SteelTypeController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
