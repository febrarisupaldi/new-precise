<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\StateService;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;
use App\Exceptions\BadRequestException;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\State\CreateStateRequest;
use App\Http\Requests\Master\State\UpdateStateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    protected StateService $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * GET /api/master/states
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->stateService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'State list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve state list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/states/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $result = $this->stateService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'State retrieved successfully.',
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
            $this->logError($e, 'StateController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve state.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/states
     */
    public function store(CreateStateRequest $request): JsonResponse
    {
        try {
            $dto    = CreateStateDTO::fromRequest($request);
            $result = $this->stateService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'State created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create state.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/states/{id}
     */
    public function update(UpdateStateRequest $request, $id): JsonResponse
    {
        try {
            $dto    = UpdateStateDTO::fromRequest($request);
            $this->stateService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "State updated successfully",
                id: $id,
                data: $dto->toArray(),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError(
                $e,
                'StateController@update',
                [
                    'id' => $id,
                    'payload' => $request->all()
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update state.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/states/check
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto    = ExistsDTO::fromRequest($request);
            $exists = $this->stateService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Check completed.',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@check', ['query' => $request->query()]);
            return $this->jsonResponse('error', 'Failed to perform check.', code: 500);
        }
    }
}
