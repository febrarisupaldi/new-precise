<?php

namespace App\Http\Controllers\Api\Master;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
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

    public function store(Request $request)
    {
        return $this->machinePressingService->create($request);
    }

    public function update(Request $request, $id)
    {
        return $this->machinePressingService->update($request, $id);
    }

    public function destroy(Request $request, $id)
    {
        return $this->machinePressingService->destroy($id);
    }
}
