<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\MachineStatus\CreateMachineStatusDTO;
use App\DTOs\Master\MachineStatus\UpdateMachineStatusDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MachineStatus\CreateMachineStatusRequest;
use App\Http\Requests\Master\MachineStatus\UpdateMachineStatusRequest;
use App\Services\Master\MachineStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MachineStatusController extends Controller
{
    private MachineStatusService $machineStatusService;

    public function __construct(MachineStatusService $machineStatusService)
    {
        $this->machineStatusService = $machineStatusService;
    }

    /**
     * GET /api/master/machine-statuses
     * 1@return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $machineStatuses = $this->machineStatusService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Statuses retrieved successfully.',
                data: $machineStatuses,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineStatusController@index', []);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve machine statuses.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-statuses/{code}
     * @routeParam {code} string required
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $machineStatus = $this->machineStatusService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Status retrieved successfully.',
                data: $machineStatus,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineStatusController@show', ['id' => $id]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve machine status.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/machine-statuses
     * @param CreateMachineStatusRequest $request
     * @return JsonResponse
     */
    public function store(CreateMachineStatusRequest $request): JsonResponse
    {
        try {
            $dto = CreateMachineStatusDTO::fromRequest($request);
            $machineStatus = $this->machineStatusService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Status created successfully.',
                data: $machineStatus,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineStatusController@store', $request->all());
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create machine status.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/machine-statuses/{code}
     * @routeParam {code} string required
     * @param UpdateMachineStatusRequest $request
     * @return JsonResponse
     */
    public function update(string $id, UpdateMachineStatusRequest $request): JsonResponse
    {
        try {
            $dto = UpdateMachineStatusDTO::fromRequest($request);
            $this->machineStatusService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Status updated successfully.',
                data: $dto->toArray(),
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineStatusController@update', $request->all());
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update machine status.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-statuses/check
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse{
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->machineStatusService->checkExist($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Status check successfully.',
                data: [
                    'exists' => $exists,
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineStatusController@check', $request->all());
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check machine status.',
                code: 500
            );
        }
    }
}
