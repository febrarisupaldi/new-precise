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
