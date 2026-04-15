<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Services\Master\State\StateService;
use App\Repositories\Master\State\StateRepository;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;
use App\Http\Requests\Master\State\CreateStateRequest;
use App\Http\Requests\Master\State\UpdateStateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller
{
    protected StateService $stateService;

    public function __construct()
    {
        $this->stateService = new StateService(new StateRepository());
    }

    /**
     * GET /api/master/states
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->stateService->getAll();
            return $this->jsonResponse('success', 'State list retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@index');
            return $this->jsonResponse('error', 'Failed to retrieve state list.', code: 500);
        }
    }

    /**
     * GET /api/master/states/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->stateService->getById($id);

            if (!$data) {
                return $this->jsonResponse('error', 'State not found.', code: 404);
            }

            return $this->jsonResponse('success', 'State retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@show', ['id' => $id]);
            return $this->jsonResponse('error', 'Failed to retrieve state.', code: 500);
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

            if (!$result['success']) {
                return $this->jsonResponse('error', $result['message'], code: 500);
            }

            return $this->jsonResponse('success', $result['message'], code: 201);
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@store', ['payload' => $request->all()]);
            return $this->jsonResponse('error', 'Failed to create state.', code: 500);
        }
    }

    /**
     * PUT /api/master/states/{id}
     */
    public function update(UpdateStateRequest $request, $id): JsonResponse
    {
        try {
            $dto    = UpdateStateDTO::fromRequest($request);
            $result = $this->stateService->update($id, $dto);

            if (!$result['success']) {
                return $this->jsonResponse('error', $result['message'], code: 404);
            }

            return $this->jsonResponse('success', $result['message']);
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@update', ['id' => $id, 'payload' => $request->all()]);
            return $this->jsonResponse('error', 'Failed to update state.', code: 500);
        }
    }

    /**
     * GET /api/master/states/check
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $column = $request->query('column');
            $value  = $request->query('value');

            if (!$column || !$value) {
                return $this->jsonResponse('error', 'Column and value are required.', code: 400);
            }

            $allowedColumns = ['state_code', 'state_name'];
            if (!in_array($column, $allowedColumns)) {
                return $this->jsonResponse('error', 'Invalid column.', code: 400);
            }

            $exists = $this->stateService->checkExist($column, $value);

            return $this->jsonResponse('success', 'Check completed.', ['exists' => $exists]);
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@check', ['query' => $request->query()]);
            return $this->jsonResponse('error', 'Failed to perform check.', code: 500);
        }
    }
}
