<?php

namespace App\Http\Controllers\Api\Master;


use App\Http\Controllers\Controller;
use App\Services\Master\StateService;
use App\DTOs\Master\State\{CreateStateDTO, UpdateStateDTO};
use App\Exceptions\BadRequestException;
use Illuminate\Http\Request;
use App\Http\Requests\Master\State\{CreateStateRequest, UpdateStateRequest};
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|State', 'States')]
class StateController extends Controller
{
    protected StateService $stateService;

    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;
    }

    /**
     * GET /api/master/states
     * 
     * Behavior:
     *  - get all states
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @return JsonResponse
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
     * 
     * Behavior:
     *  - get state by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
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
     * 
     * Behavior:
     *  - create state
     * 
     * Body:
     *  - state name required, example: "State Name"
     *  - country id required, example: 1
     *  - is active required, example: true
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param CreateStateRequest $request
     * @return JsonResponse
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
     * 
     * Behavior:
     *  - update state
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - state name optional, example: "State Name"
     *  - country id optional, example: 1
     *  - is active optional, example: true
     *  - updated by required, example: "admin"
     *  - reason required, example: "Updated description"
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateStateRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateStateRequest $request): JsonResponse
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
     * 
     * Behavior:
     *  - check if state exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["status_code"]
     *  - values[] required, example: ["RUNNING"]
     * 
     * Available Request:
     *  - /api/master/states/check?columns[]=state_name&values[]=Jakarta
     *  - /api/master/states/check?columns[]=state_code&values[]=JKT
     * 
     * Authentication:
     *  - Requires valid bearer Token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {

            $exists = $this->stateService->checkExist($request->query());

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
