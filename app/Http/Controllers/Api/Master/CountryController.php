<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\CountryService;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Country\CreateCountryRequest;
use App\Http\Requests\Master\Country\UpdateCountryRequest;
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * GET /api/master/countries
     * 
     * - Behavior:
     *   - Return all country data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->countryService->all();


            return $this->jsonResponse(
                status: 'ok',
                message: 'Country list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve country list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/countries/{id}
     * 
     * - Behavior:
     *   - Return single country data based on id
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
            $result = $this->countryService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Country retrieved successfully.',
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
            $this->logError($e, 'CountryController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve country.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/countries
     * 
     * - Behavior:
     *   - Create single country data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateCountryRequest $request
     * @return JsonResponse
     */
    public function store(CreateCountryRequest $request): JsonResponse
    {
        try {
            $dto    = CreateCountryDTO::fromRequest($request);
            $result = $this->countryService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Country created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create country.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/countries/{id}
     * 
     * - Behavior:
     *   - Update single country data based on id
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateCountryRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateCountryRequest $request): JsonResponse
    {
        try {
            $dto = UpdateCountryDTO::fromRequest($request);
            $this->countryService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "country updated successfully",
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
            $this->logError($e, 'CountryController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update country.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/countries/check
     * 
     * - Behavior:
     *   - Check if data already exists
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
            $dto = ExistsDTO::fromRequest($request);

            $exists = $this->countryService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'StateController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
