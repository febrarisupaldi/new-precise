<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\City\CreateCityRequest;
use App\Http\Requests\Master\City\UpdateCityRequest;
use App\Services\Master\CityService;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    protected CityService $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    /**
     * GET /api/master/cities
     * 
     * - Behavior:
     *   - Return all city data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->cityService->all();


            return $this->jsonResponse(
                status: 'ok',
                message: 'City list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve city list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cities/{id}
     * 
     * - Behavior:
     *   - Return single city data based on id
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->cityService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'City retrieved successfully.',
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
            $this->logError($e, 'CityController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve city.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/cities
     * 
     * - Behavior:
     *   - Create single city data
     * 
     * - Body:
     *   - city code required and unique, example: JKT
     *   - city name required, example: "Jakarta", "Bandung"
     *   - state id required, example: 1
     *   - created by required, example: Supaldi
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateCityRequest $request
     * @return JsonResponse
     */
    public function store(CreateCityRequest $request): JsonResponse
    {
        try {
            $dto    = CreateCityDTO::fromRequest($request);
            $result = $this->cityService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'City created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CityController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create city.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/cities/{id}
     * 
     * - Behavior:
     *   - Update single city data based on id
     * 
     * - Body:
     *   - city code required and unique, example: JKT
     *   - city name required, example: "Jakarta", "Bandung"
     *   - state id required and id must be exists in state table, example: 1
     *   - updated by will using logged in user
     *   - reason required, example: "Change city name from JKT to JKT1"
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateCityRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateCityRequest $request): JsonResponse
    {
        try {
            $dto  = UpdateCityDTO::fromRequest($request);
            $this->cityService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: "City updated successfully",
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
                'CityController@update',
                [
                    'id' => $id,
                    'payload' => $request->all()
                ]
            );

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update city.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/cities/check
     * 
     * - Behavior:
     *   - Check if data already exists
     * 
     * - Business Rules:
     *   - columns and values required and must be same length
     * 
     * - Query Parameters:
     *   - columns[] required, example: ["city_name"]
     *   - values[] required, example: ["test"]
     * 
     * - Available Request:
     *   - /api/master/cities/check?columns[]=city_name&values[]=test
     *   - /api/master/cities/check?columns[]=city_code&values[]=test
     
     * - Available 
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto    = ExistsDTO::fromRequest($request);
            $exists = $this->cityService->checkExist($dto);

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
