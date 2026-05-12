<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\Country\CountryService;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\Country\CreateCountryRequest;
use App\Http\Requests\Master\Country\UpdateCountryRequest;
use Illuminate\Http\JsonResponse;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * GET /api/master/countries
     * @return {JsonResponse}
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->countryService->all();

            if (!$result['data']) {
                return $this->jsonResponse('error', 'Country not found.', code: 404);
            }

            return $this->jsonResponse('ok', 'Country list retrieved successfully.', $result['data'], code: 200);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@index');

            return $this->jsonResponse('error', 'Failed to retrieve country list.', code: 500);
        }
    }

    /**
     * GET /api/master/countries/{id}
     * @routeParam {id} required
     * @return {JsonResponse}
     */
    public function show($id): JsonResponse
    {
        try {
            $result = $this->countryService->find($id);

            if (!$result['data']) {
                return $this->jsonResponse('error', 'Country not found.', code: 404);
            }

            return $this->jsonResponse('ok', 'Country retrieved successfully.', $result['data'], code: 200);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@show', ['id' => $id]);

            return $this->jsonResponse('error', 'Failed to retrieve country.', code: 500);
        }
    }

    /**
     * POST /api/master/countries
     * @param CreateCountryRequest $request
     * @return {JsonResponse}
     */
    public function store(CreateCountryRequest $request): JsonResponse
    {
        try {
            $dto    = CreateCountryDTO::fromRequest($request);
            $result = $this->countryService->create($dto);

            if (!$result['success']) {
                return $this->jsonResponse('error', $result['message'], code: 500);
            }

            return $this->jsonResponse('success', $result['message'], code: 201);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@store', ['payload' => $request->all()]);

            return $this->jsonResponse('error', 'Failed to create country.', code: 500);
        }
    }

    /**
     * PUT /api/master/countries/{id}
     * @routeParam {id} required
     * @param UpdateCountryRequest $request
     * @return {JsonResponse}
     */
    public function update($id, UpdateCountryRequest $request): JsonResponse
    {
        try {
            $dto    = UpdateCountryDTO::fromRequest($request);
            $result = $this->countryService->update($id, $dto);

            if (!$result['success']) {
                return $this->jsonResponse('error', $result['message'], code: 404);
            }

            return $this->jsonResponse('success', $result['message'], $result['data'], code: 200);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse('error', 'Failed to update country.', code: 500);
        }
    }

    /**
     * GET /api/master/countries/check
     * @param ExistsRequest $request
     * @return {JsonResponse}
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);

            $exists = $this->countryService->checkExist($dto);

            return $this->jsonResponse('success', 'Check completed.', [
                'exists' => $exists
            ]);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@check', ['query' => $request->query()]);
            return $this->jsonResponse('error', 'Failed to perform check.', code: 500);
        }
    }
}
