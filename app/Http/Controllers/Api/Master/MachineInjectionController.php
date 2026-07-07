<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\MachineInjection\{CreateMachineInjectionDTO, UpdateMachineInjectionDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MachineInjection\{CreateMachineInjectionRequest, UpdateMachineInjectionRequest};
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
     * 
     * - Behavior:
     *   - Return all machine injection data
     * 
     * - Query Parameters:
     *   - machine_code string optional
     * 
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
     * 
     * - Behavior:
     *   - Return single machine injection data based on id
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  int  $id
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
     * 
     * - Behavior:
     *   - Create single machine injection data
     * 
     * - Body:
     *   - machine_code required, example: "MI-001"
     *   - old_machine_code optional, example: "Machine Injection 1"
     *   - machine_type required, example: "Injection"
     *   - machine_brand required, example: "Brand"
     *   - machine_model required, example: "Model"
     *   - machine_tonnage required, example: "100"
     *   - machine_distance required, example: "100"
     *   - machine_slide_distance required, example: "100"
     *   - machine_shuttle_distance required, example: "100"
     *   - customer_id required, example: 1
     *   - created_by required, example: "User"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
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
     * 
     * - Behavior:
     *   - Update single machine injection data based on id
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Body:
     *   - machine_code optional, example: "MI-001"
     *   - old_machine_code optional, example: "Machine Injection 1"
     *   - machine_type optional, example: "Injection"
     *   - machine_brand optional, example: "Brand"
     *   - machine_model optional, example: "Model"
     *   - machine_tonnage optional, example: "100"
     *   - machine_distance optional, example: "100"
     *   - machine_slide_distance optional, example: "100"
     *   - machine_shuttle_distance optional, example: "100"
     *   - customer_id optional, example: 1
     *   - updated_by required, example: "User"
     *   - reason required, example: "Update reason"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam int  $id
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
     * 
     * - Behavior:
     *   - Check if machine injection exists based on machine_code or (line code and line number)
     * 
     * - Query Parameters:
     *   - columns[] required, example: ["machine_code", "line_code", "line_number"]
     *   - values[] required, example: ["MI-001", "A", "1"]
     * 
     * - Available Request:
     *   - GET /api/master/machine-injections/check?columns[]=machine_code&values[]=MI-001
     *   - GET /api/master/machine-injections/check?columns[]=line_code,line_number&values[]=A,1
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
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
