<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\MachinePressing\CreateMachinePressingDTO;
use App\DTOs\Master\MachinePressing\UpdateMachinePressingDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MachinePressing\CreateMachinePressingRequest;
use App\Http\Requests\Master\MachinePressing\UpdateMachinePressingRequest;
use App\Services\Master\MachinePressingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MachinePressingController extends Controller
{
    private MachinePressingService $machinePressingService;
    
    public function __construct(MachinePressingService $machinePressingService)
    {
        $this->machinePressingService = $machinePressingService;
    }

    /**
     * GET /api/master/machine-pressings
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->machinePressingService->all($request->toArray());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachinePressingController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Machine Pressing list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-pressings/{id}
     * @param int $id
     * @return JsonResponse
     */

    public function show(int $id): JsonResponse
    {
        try {
            $machineInjection = $this->machinePressingService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Pressing retrieved successfully.',
                data: $machineInjection,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachinePressingController@show', ['id' => $id]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Machine Pressing.',
                code: 500
            );
        }
    }


    /**
     * POST /api/master/machine-pressings
     * @param CreateMachinePressingRequest $request
     * @return JsonResponse
     */
    public function store(CreateMachinePressingRequest $request)
    {
        try {
            $dto = CreateMachinePressingDTO::fromRequest($request);
            $result = $this->machinePressingService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Pressing created successfully.',
                id: $result,
                data: $dto->toArray(),
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachinePressingController@store');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Machine Pressing.',
                code: 500
            );
        }
    }

    /**
     * UPDATE /api/master/machine-pressings/{id}
     * @param int $id
     * @param UpdateMachinePressingRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateMachinePressingRequest $request)
    {
        try {
            $dto = UpdateMachinePressingDTO::fromRequest($request);
            $this->machinePressingService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Pressing updated successfully.',
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
            $this->logError($e, 'MachinePressingController@update', ['id' => $id, 'payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Machine Pressing.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-pressings/check
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsRequest::fromRequest($request);
            $exists = $this->machinePressingService->checkExist($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Pressing exists successfully.',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachinePressingController@check');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check Machine Pressing.',
                code: 500
            );
        }
    }
}
