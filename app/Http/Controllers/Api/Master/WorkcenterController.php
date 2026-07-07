<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\Workcenter\{CreateWorkcenterDTO, UpdateWorkcenterDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Workcenter\{CreateWorkcenterRequest, UpdateWorkcenterRequest};
use App\Services\Master\WorkcenterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkcenterController extends Controller
{
    protected WorkcenterService $workcenterService;

    public function __construct(WorkcenterService $workcenterService)
    {
        $this->workcenterService = $workcenterService;
    }

    /**
     * GET /api/master/workcenters
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
     * @routeParam {id} required
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
     * @routeParam {id} required
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
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);
            $exists = $this->workcenterService->checkExist($dto);

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
