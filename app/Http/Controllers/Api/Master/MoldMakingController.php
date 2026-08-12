<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\MoldMaking\{CreateMoldMakingDTO, UpdateMoldMakingDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MoldMaking\{CreateMoldMakingRequest, UpdateMoldMakingRequest};
use App\Services\Master\MoldMakingService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group("MASTER|Mold Making", "MoldMaking")]
class MoldMakingController extends Controller
{
    protected MoldMakingService $moldMakingService;

    public function __construct(MoldMakingService $moldMakingService)
    {
        $this->moldMakingService = $moldMakingService;
    }

    /**
     * GET /api/master/mold-makings
     * 
     * Behavior: 
     *  - Return all mold making data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->moldMakingService->all();
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Making data retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Exception $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                data: null,
                code: 500
            );
        }
    }

    /**
     * GET /api/master/mold-makings/{id}
     * 
     * Behavior: 
     *  - Return specific mold making data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Making data retrieved successfully.',
                data: $this->moldMakingService->find($id),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldMakingController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve mold making.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/mold-makings
     * 
     * Behavior: 
     *  - Create new mold making data
     * 
     * Body:
     *  - estimation number string required, example: EST123
     *  - created by string required, example: paldi
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param CreateMoldMakingRequest $request
     * @return JsonResponse
     */
    public function store(CreateMoldMakingRequest $request): JsonResponse
    {
        try {
            $dto = CreateMoldMakingDTO::fromRequest($request);

            $result = $this->moldMakingService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Making data created successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldMakingController@store');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create mold making.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/mold-makings/{id}
     * 
     * Behavior: 
     *  - Update mold making data
     * 
     * Body:
     *  - estimation number string optional, example: EST123
     *  - updated by string optional, example: paldi
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @param UpdateMoldMakingRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateMoldMakingRequest $request): JsonResponse
    {
        try {
            $dto = UpdateMoldMakingDTO::fromRequest($request);
            $this->moldMakingService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Making data updated successfully.',
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
            $this->logError($e, 'MoldMakingController@update', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update mold making.',
                code: 500
            );
        }
    }
}
