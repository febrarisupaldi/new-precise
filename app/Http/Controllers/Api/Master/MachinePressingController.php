<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\MachinePressing\{CreateMachinePressingDTO, UpdateMachinePressingDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\MachinePressing\{CreateMachinePressingRequest, UpdateMachinePressingRequest};
use App\Services\Master\MachinePressingService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group('MASTER|Machine Pressing', 'Machine Pressings')]
class MachinePressingController extends Controller
{
    private MachinePressingService $machinePressingService;

    public function __construct(MachinePressingService $machinePressingService)
    {
        $this->machinePressingService = $machinePressingService;
    }

    /**
     * GET /api/master/machine-pressings
     * 
     * Behavior: 
     *  - Return all machine pressing data
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
     * 
     * Behavior:
     *  - Return single machine pressing data based on id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *  - Create single machine pressing data
     * 
     * Body:
     *  - machine code required unique, example: "Machine Pressing 1"
     *  - old machine code optional, example: "Machine Pressing 1"
     *  - machine location required, example: "Machine Pressing 1"
     *  - line code required, example: "Machine Pressing 1"
     *  - line number optional, example: "Machine Pressing 1"
     *  - tonnage required, example: "1"
     *  - serial number required, example: "1"
     *  - production year required, example: "2022"
     *  - brand required, example: "Brand Name"
     *  - motor power required, example: "1"
     *  - heater power required, example: "1"
     *  - can plain optional, example: true
     *  - can print optional, example: true
     *  - can mug optional, example: true
     *  - can bico lg optional, example: true
     *  - can bico material optional, example: true
     *  - priority rank required, example: 1
     *  - machine status code required, example: 1
     *  - created by required, example: "Supaldi"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
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
     * PUT /api/master/machine-pressings/{id}
     * 
     * Behavior:
     *  - Update single machine pressing data based on id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - machine code required unique, example: "Machine Pressing 1"
     *  - old machine code optional, example: "Machine Pressing 1"
     *  - machine location required, example: "Machine Pressing 1"
     *  - line code required, example: "Machine Pressing 1"
     *  - line number optional, example: "Machine Pressing 1"
     *  - tonnage required, example: "1"
     *  - serial number required, example: "1"
     *  - production year required, example: "2022"
     *  - brand required, example: "Brand Name"
     *  - motor power required, example: "1"
     *  - heater power required, example: "1"
     *  - can plain optional, example: true
     *  - can print optional, example: true
     *  - can mug optional, example: true
     *  - can bico lg optional, example: true
     *  - can bico material optional, example: true
     *  - priority rank required, example: 1
     *  - machine status code required, example: 1
     *  - updated by required, example: "Supaldi"
     *  - reason required, example: "Testing"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *  - Check if data already exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["machine_code"]
     *  - values[] required, example: ["Machine Pressing 1"]
     * 
     * Available Request:
     *  - GET /api/master/machine-pressings/check?columns[]=machine_code&values[]=Machine Pressing 1
     *  - GET /api/master/machine-pressings/check?columns[]=line_code,line_number&values[]=1,1
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
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
