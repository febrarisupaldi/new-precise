<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Services\Master\Country\CountryService;
use App\Repositories\Master\Country\CountryRepository;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use App\Http\Requests\Master\Country\CreateCountryRequest;
use App\Http\Requests\Master\Country\UpdateCountryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct()
    {
        $this->countryService = new CountryService(new CountryRepository());
    }

    /**
     * GET /api/master/countries
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->countryService->getAll();

            return $this->jsonResponse('success', 'Country list retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@index');

            return $this->jsonResponse('error', 'Failed to retrieve country list.', code: 500);
        }
    }

    /**
     * GET /api/master/countries/{id}
     */
    public function show($id): JsonResponse
    {
        try {
            $data = $this->countryService->getById($id);

            if (!$data) {
                return $this->jsonResponse('error', 'Country not found.', code: 404);
            }

            return $this->jsonResponse('success', 'Country retrieved successfully.', $data);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@show', ['id' => $id]);

            return $this->jsonResponse('error', 'Failed to retrieve country.', code: 500);
        }
    }

    /**
     * POST /api/master/countries
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
     */
    public function update(UpdateCountryRequest $request, $id): JsonResponse
    {
        try {
            $dto    = UpdateCountryDTO::fromRequest($request);
            $result = $this->countryService->update($id, $dto);

            if (!$result['success']) {
                return $this->jsonResponse('error', $result['message'], code: 404);
            }

            return $this->jsonResponse('success', $result['message']);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse('error', 'Failed to update country.', code: 500);
        }
    }

    /**
     * GET /api/master/countries/check
     * Check if a column value exists
     */
    public function check(Request $request): JsonResponse
    {
        try {
            $column = $request->query('column');
            $value  = $request->query('value');

            if (!$column || !$value) {
                return $this->jsonResponse('error', 'Column and value are required.', code: 400);
            }

            // Optional: Limit allowed columns for security
            $allowedColumns = ['country_code', 'country_name'];
            if (!in_array($column, $allowedColumns)) {
                return $this->jsonResponse('error', 'Invalid column.', code: 400);
            }

            $exists = $this->countryService->checkExist($column, $value);

            return $this->jsonResponse('success', 'Check completed.', [
                'exists' => $exists
            ]);
        } catch (\Throwable $e) {
            $this->logError($e, 'CountryController@check', ['query' => $request->query()]);
            return $this->jsonResponse('error', 'Failed to perform check.', code: 500);
        }
    }
}
