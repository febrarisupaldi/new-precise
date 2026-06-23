<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\MachineInjection\CreateMachineInjectionDTO;
use App\DTOs\Master\MachineInjection\UpdateMachineInjectionDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MachineInjection\CreateMachineInjectionRequest;
use App\Http\Requests\Master\MachineInjection\UpdateMachineInjectionRequest;
use App\Services\Master\MachineInjectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MachineInjectionController extends Controller
{
    private MachineInjectionService $machineInjectionService;

    public function __construct(MachineInjectionService $machineInjectionService)
    {
        $this->machineInjectionService = $machineInjectionService;
    }

    /**
     * GET /api/master/machine-injections
     * @queryParam machine_code string optional
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->machineInjectionService->all($request->toArray());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineInjectionController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Machine Injection list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-injections/{id}
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $machineInjection = $this->machineInjectionService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection retrieved successfully.',
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
            $this->logError($e, 'MachineInjectionController@show', ['id' => $id]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Machine Injection.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/machine-injections
     * @param CreateMachineInjectionRequest $request
     * @return JsonResponse
     */
    public function store(CreateMachineInjectionRequest $request): JsonResponse
    {
        try {
            $dto = CreateMachineInjectionDTO::fromRequest($request);
            $result = $this->machineInjectionService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection created successfully.',
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
            $this->logError($e, 'MachineInjectionController@store', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Machine Injection.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/machine-injections/{id}
     * @routeParam {id} required
     * @param UpdateMachineInjectionRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateMachineInjectionRequest $request): JsonResponse
    {
        try {
            $dto = UpdateMachineInjectionDTO::fromRequest($request);
            $this->machineInjectionService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection updated successfully.',
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
            $this->logError($e, 'MachineInjectionController@update', ['id' => $id, 'payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Machine Injection.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/machine-injections/check
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->machineInjectionService->checkExist($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Machine Injection checked successfully.',
                data: ['exists' => $exists],
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MachineInjectionController@check', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check Machine Injection.',
                code: 500
            );
        }
    }
}
