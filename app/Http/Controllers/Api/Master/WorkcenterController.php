<?php

namespace App\Http\Controllers\Api\Master;


use App\DTOs\Master\Workcenter\{CreateWorkcenterDTO, UpdateWorkcenterDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\Workcenter\{CreateWorkcenterRequest, UpdateWorkcenterRequest};
use App\Services\Master\WorkcenterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Workcenter', 'Workcenters')]
class WorkcenterController extends Controller
{
    protected WorkcenterService $workcenterService;

    public function __construct(WorkcenterService $workcenterService)
    {
        $this->workcenterService = $workcenterService;
    }

    /**
     * GET /api/master/workcenters
     * 
     * Behavior:
     *  - Return all workcenter data
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $result = $this->workcenterService->all($request->toArray());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve workcenter list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/workcenters/{id}
     * 
     * Behavior:
     *  - Return single workcenter data
     * 
     * Authentication:
     *  - Requires valid bearer token
     *
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->workcenterService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                id: $id,
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@show');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve workcenter.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/workcenters
     * 
     * Behavior:
     *  - Create single workcenter data
     * 
     * Body:
     *  - workcenter code required, example: "WC1"
     *  - workcenter name required, example: "Workcenter 1"
     *  - description optional, example: "Description"
     *  - default warehouse optional, example: 1
     *  - is active optional, example: true
     *  - production type required, example: "ML" or "PL"
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function store(CreateWorkcenterRequest $request): JsonResponse
    {
        try {
            $dto = CreateWorkcenterDTO::fromRequest($request);
            $id = $this->workcenterService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter created successfully.',
                data: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@store');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create workcenter.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/workcenters/{id}
     * 
     * Behavior:
     *  - Update single workcenter data
     * 
     * Body:
     *  - workcenter code optional, example: "WC1"
     *  - workcenter name optional, example: "Workcenter 1"
     *  - description optional, example: "Description"
     *  - default warehouse optional, example: 1
     *  - is active optional, example: true
     *  - production type optional, example: "ML" or "PL"
     *  - updated by required, example: "admin"
     *  - reason required, example: "test"
     * 
     * Authentication:
     *  - Requires valid bearer token
     *
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function update(int $id, UpdateWorkcenterRequest $request): JsonResponse
    {
        try {
            $dto = UpdateWorkcenterDTO::fromRequest($request);
            $this->workcenterService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter updated successfully.',
                data: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@update');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update workcenter.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/workcenters/{id}
     *
     * @routeParam {id} required
     */
    public function delete(int $id, DeleteRequest $request): JsonResponse
    {
        try {
            $this->workcenterService->delete($id, $request->toArray());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter deleted successfully.',
                data: null,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@delete');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete workcenter.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/workcenters/check?columns[]=column1,column2&values[]=value1,value2
     */
    public function check(Request $request): JsonResponse
    {
        try {

            $exists = $this->workcenterService->checkExist($request->query());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Workcenter checked successfully.',
                data: ['exists' => $exists],
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'WorkcenterController@check');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check workcenter.',
                code: 500
            );
        }
    }
}
