<?php

namespace App\Http\Controllers\Api\Engineering;

use App\DTOs\Engineering\MachinePressingActivity\CreateMachinePressingActivityDTO;
use App\DTOs\Engineering\MoldPressingActivity\CreateMoldPressingActivityDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Engineering\MachinePressingActivity\CreateMachinePressingActivityRequest;
use App\Http\Requests\Engineering\MachinePressingActivity\IndexMachinePressingActivityRequest;
use App\Services\Engineering\MachinePressingActivityService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Throwable;

#[Group('ENGINEERING|Machine Pressing Activity', 'Machine Pressing Activities')]
class MachinePressingActivityController extends Controller
{
    protected MachinePressingActivityService $machinePressingActivityService;

    public function __construct(MachinePressingActivityService $machinePressingActivityService)
    {
        $this->machinePressingActivityService = $machinePressingActivityService;
    }

    /**
     * GET /api/engineering/machine-pressing-activities
     * 
     * @param IndexMachinePressingActivityRequest $request
     * @return JsonResponse
     */
    public function index(IndexMachinePressingActivityRequest $request): JsonResponse
    {

        try {
            $result = $this->machinePressingActivityService->all($request->validated());

            return $this->jsonResponse(
                status: "ok",
                message: "Machine pressing activity list retrieved successfully.",
                data: $result,
                code: 200
            );
        } catch (Throwable $e) {
            return $this->jsonResponse(
                status: "failed",
                message: $e->getMessage(),
                code: 400
            );
        }
    }


    /**
     * POST /api/engineering/machine-pressing-activities
     * 
     * @param CreateMachinePressingActivityRequest $request
     * @return JsonResponse
     */
    public function store(
        CreateMachinePressingActivityRequest $request
    ): JsonResponse {
        try {
            $dto = CreateMachinePressingActivityDTO::fromRequest($request);
            $mold_dto = CreateMoldPressingActivityDTO::fromRequest($request);
            $result = $this->machinePressingActivityService->create($dto, $mold_dto);

            return $this->jsonResponse(
                status: "ok",
                message: "Machine pressing activity created successfully.",
                data: $result,
                code: 201
            );
        } catch (Throwable $e) {
            return $this->jsonResponse(
                status: "failed",
                message: $e->getMessage(),
                code: 400
            );
        }
    }


    /**
     * DELETE /api/engineering/machine-pressing-activities/{id}
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $result = $this->machinePressingActivityService->delete($id);

            return $this->jsonResponse(
                status: "ok",
                message: "Machine pressing activity deleted successfully.",
                data: $result,
                code: 200
            );
        } catch (Throwable $e) {
            return $this->jsonResponse(
                status: "failed",
                message: $e->getMessage(),
                code: 400
            );
        }
    }
}
