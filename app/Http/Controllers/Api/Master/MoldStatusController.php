<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\MoldStatus\{CreateMoldStatusDTO, UpdateMoldStatusDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MoldStatus\{CreateMoldStatusRequest, UpdateMoldStatusRequest};
use Illuminate\Http\Request;
use App\Services\Master\MoldStatusService;
use Illuminate\Http\JsonResponse;

class MoldStatusController extends Controller
{
    private MoldStatusService $moldStatusService;

    public function __construct(MoldStatusService $moldStatusService)
    {
        $this->moldStatusService = $moldStatusService;
    }

    /**
     * GET /api/master/mold-statuses
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
     * GET /api/master/mold-statuses/{id}
     * @routeParam {id} required
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
     * PUT /api/master/mold-statuses/{id}
     * @param string $id
     * @param UpdateMoldStatusRequest $request
     * @return JsonResponse
     */
    public function update(string $id, UpdateMoldStatusRequest $request): JsonResponse
    {
        try {
            $data = UpdateMoldStatusDTO::fromRequest($request);
            $this->moldStatusService->update($id, $data);
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
            $this->logError($e, 'MoldStatusController@update', ['id' => $id, 'payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Mold Status.',
                code: 500
            );
        }
    }

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
