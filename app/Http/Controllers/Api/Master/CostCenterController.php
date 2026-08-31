<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\CostCenter\CreateCostCenterDTO;
use App\DTOs\Master\CostCenter\UpdateCostCenterDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\CostCenter\CreateCostCenterRequest;
use App\Http\Requests\Master\CostCenter\UpdateCostCenterRequest;
use App\Services\Master\CostCenterService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group("MASTER|Cost Center", "Cost Center")]
class CostCenterController extends Controller
{
    protected CostCenterService $costCenterService;

    public function __construct(CostCenterService $costCenterService)
    {
        $this->costCenterService = $costCenterService;
    }

    /**
     * GET /api/master/cost-centers
     * 
     * Behavior:
     *   - Return all Cost Center data
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->costCenterService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Cost Center list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CostCenterController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Cost Center list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cost-centers/{id}
     * 
     * Behavior:
     *   - Return single Cost Center data based on id
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->costCenterService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Cost Center retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CostCenterController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Cost Center.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/cost-centers
     * 
     * Behavior:
     *   - Create single Cost Center data
     * 
     * Body:
     *   - cost center code required, example: "000"
     *   - cost center name required, example: "test"
     *   - created by will using logged in user
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateCostCenterRequest $request
     * @return JsonResponse
     */
    public function store(CreateCostCenterRequest $request): JsonResponse
    {
        try {
            $dto    = CreateCostCenterDTO::fromRequest($request);
            $result = $this->costCenterService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Cost Center created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CostCenterController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Cost Center.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/cost-centers/{id}
     * 
     * Behavior:
     *   - Update single Cost Center data
     * 
     * Body:
     *   - cost center code required, example: "000"
     *   - cost center name required, example: "test"
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Testing"
     * 
     * Path:
     *   - id required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateCostCenterRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateCostCenterRequest $request): JsonResponse
    {
        try {
            $dto = UpdateCostCenterDTO::fromRequest($request);
            $this->costCenterService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Cost Center updated successfully.",
                id: $id,
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
            $this->logError($e, 'CostCenterController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Cost Center.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cost-centers/check
     * 
     * Behavior:
     *   - Check if data already exists
     * 
     * Query Parameters:
     *   - cost_center_code required, example: "test"
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $exists = $this->costCenterService->checkExist($request->query());

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CostCenterController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
