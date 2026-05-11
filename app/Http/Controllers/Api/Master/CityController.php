<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\City\CreateCityRequest;
use App\Http\Requests\Master\City\UpdateCityRequest;
use App\Repositories\Master\City\CityRepository;
use App\Services\Master\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * GET /api/master/cities
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->cityService->all();
            return $this->jsonResponse('success', 'City list retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@index');
            return $this->jsonResponse('error', 'Failed to retrieve city list.', code: 500);
        }
    }

    /**
     * GET /api/master/cities/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->cityService->find($id);

            if (!$data) {
                return $this->jsonResponse('error', 'City not found.', code: 404);
            }

            return $this->jsonResponse('success', 'City retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@show', ['id' => $id]);

            return $this->jsonResponse('error', 'Failed to retrieve city.', code: 500);
        }
    }

    /**
     * POST /api/master/cities
     */
    public function store(CreateCityRequest $request): JsonResponse
    {
        try {
            $dto  = CreateCityDTO::fromRequest($request);
            $data = $this->cityService->create($dto);
            return $this->jsonResponse('success', $data['message'], id: $data['id']);
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@store', $request->all());
            return $this->jsonResponse('error', 'Failed to create City.', code: 500);
        }
    }

    public function update(int $id, UpdateCityRequest $request): JsonResponse
    {
        try {
            $dto  = UpdateCityDTO::fromRequest($request);
            $data = $this->cityService->update($id, $dto);
            return $this->jsonResponse('success', $data['message'], id: $data['id']);
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@store', $request->all());
            return $this->jsonResponse('error', 'Failed to create City.', code: 500);
        }
    }

    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto    = ExistsDTO::fromRequest($request);
            $exists = $this->cityService->checkExist($dto);

            return $this->jsonResponse('success', 'Check completed.', [
                'exists' => $exists
            ]);
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@check', ['query' => $request->query()]);
            return $this->jsonResponse('error', 'Failed to perform check.', code: 500);
        }
    }
}
