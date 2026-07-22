<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\MoldStatus\{CreateMoldStatusDTO, UpdateMoldStatusDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MoldStatus\{CreateMoldStatusRequest, UpdateMoldStatusRequest};
use App\Services\Master\MoldStatusService;
use Illuminate\Http\JsonResponse;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Mold Status', 'Mold Statuses')]
class MoldStatusController extends Controller
{
    private MoldStatusService $moldStatusService;

    public function __construct(MoldStatusService $moldStatusService)
    {
        $this->moldStatusService = $moldStatusService;
    }

    /**
     * GET /api/master/mold-statuses
     * 
     * Behavior:
     *  - get all mold statuses
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $moldStatuses = $this->moldStatusService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Status list retrieved successfully.',
                data: $moldStatuses,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldStatusController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Mold Status list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/mold-statuses/{code}
     * 
     * Behavior:
     *  - get mold status by code
     *
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @routeParam {code} required
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $moldStatus = $this->moldStatusService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Status retrieved successfully.',
                data: $moldStatus,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldStatusController@show', ['id' => $id]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Mold Status.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/mold-statuses
     * 
     * Behavior:
     *  - create mold status
     *
     * Body:
     *  - status_code required, example: "RUNNING"
     *  - status_description optional, example: "Machine is running"
     *  - is_active required, example: true
     *  - created_by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function store(CreateMoldStatusRequest $request): JsonResponse
    {
        try {
            $data = CreateMoldStatusDTO::fromRequest($request);
            $id = $this->moldStatusService->create($data);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Status created successfully.',
                data: $data->toArray(),
                id: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldStatusController@store');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Mold Status.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/mold-statuses/{code}
     * 
     * Behavior:
     *  - update mold status
     *
     * Body:
     *  - status_description optional, example: "Machine is running"
     *  - is_active required, example: true
     *  - updated_by required, example: "admin"
     *  - reason required, example: "Testing"
     * 
     * Route Parameter:
     *  - code required, example: "RUNNING"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param string $code
     * @param UpdateMoldStatusRequest $request
     * @return JsonResponse
     */
    public function update(string $code, UpdateMoldStatusRequest $request): JsonResponse
    {
        try {
            $data = UpdateMoldStatusDTO::fromRequest($request);
            $this->moldStatusService->update($code, $data);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Status updated successfully.',
                data: $data->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldStatusController@update', ['id' => $code, 'payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Mold Status.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/mold-statuses/check
     * 
     * Behavior:
     *  - check if mold status exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["status_code"]
     *  - values[] required, example: ["RUNNING"]
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function exists(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->moldStatusService->checkExist($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Status exists check completed.',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldStatusController@exists');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform Mold Status exists check.',
                code: 500
            );
        }
    }
}
