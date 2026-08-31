<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\CoolingMethod\{CreateCoolingMethodDTO, UpdateCoolingMethodDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\CoolingMethod\{CreateCoolingMethodRequest, UpdateCoolingMethodRequest};
use App\Services\Master\CoolingMethodService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group("MASTER|Cooling Method", "Cooling Method")]
class CoolingMethodController extends Controller
{
    protected CoolingMethodService $coolingMethodService;

    public function __construct(CoolingMethodService $coolingMethodService)
    {
        $this->coolingMethodService = $coolingMethodService;
    }

    /**
     * GET /api/master/cooling-methods
     * 
     * Behavior: 
     *  - Return all cooling method data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->coolingMethodService->all();
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Cooling Method data retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {

            $this->logError(
                $e,
                'CoolingMethodController@index'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve cooling method data.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cooling-methods/{id}
     * 
     * Behavior: 
     *  - Return specific cooling method data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $result = $this->coolingMethodService->find($id);
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Cooling Method data retrieved successfully.',
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
            $this->logError($e, 'CoolingMethodController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve cooling method data.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/cooling-methods
     * 
     * Behavior: 
     *  - Create new cooling method data
     * 
     * Body:
     *  - name string required, example: Air Cooling
     *  - description string optional
     *  - created by string required, example: paldi
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param CreateCoolingMethodRequest $request
     * @return JsonResponse
     */
    public function store(CreateCoolingMethodRequest $request): JsonResponse
    {
        try {
            $dto = CreateCoolingMethodDTO::fromRequest($request);
            $result = $this->coolingMethodService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Cooling Method data created successfully.',
                data: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'CoolingMethodController@store'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create cooling method data.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/cooling-methods/{id}
     * 
     * Behavior: 
     *  - Update cooling method data
     * 
     * Body:
     *  - name string optional, example: Air Cooling
     *  - description string optional
     *  - updated by string optional, example: paldi
     *  - reason string required, example: Update cooling method data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @param UpdateCoolingMethodRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateCoolingMethodRequest $request): JsonResponse
    {
        try {
            $dto = UpdateCoolingMethodDTO::fromRequest($request);
            $this->coolingMethodService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Cooling Method data updated successfully.',
                id: $id,
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'CoolingMethodController@update'
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update cooling method data.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cooling-methods/check
     * 
     * Behavior: 
     *  - Check if cooling method already exists
     * 
     * Query Parameters:
     *  - name string required, example: Air Cooling
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $exists = $this->coolingMethodService->checkExist($request->query());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Check completed.',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CoolingMethodController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
