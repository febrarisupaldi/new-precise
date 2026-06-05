<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\CompanyTypeService;
use App\DTOs\Master\CompanyType\CreateCompanyTypeDTO;
use App\DTOs\Master\CompanyType\UpdateCompanyTypeDTO;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\CompanyType\CreateCompanyTypeRequest;
use App\Http\Requests\Master\CompanyType\UpdateCompanyTypeRequest;
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;

class CompanyTypeController extends Controller
{
    protected CompanyTypeService $companyTypeService;

    public function __construct(CompanyTypeService $companyTypeService)
    {
        $this->companyTypeService = $companyTypeService;
    }

    /**
     * GET /api/master/company-types
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->companyTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Company Type list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CompanyTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Company Type list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/company-types/{id}
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->companyTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Company Type retrieved successfully.',
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
            $this->logError($e, 'CompanyTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Company Type.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/company-types
     * @param CreateCompanyTypeRequest $request
     * @return JsonResponse
     */
    public function store(CreateCompanyTypeRequest $request): JsonResponse
    {
        try {
            $dto    = CreateCompanyTypeDTO::fromRequest($request);
            $result = $this->companyTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Company Type created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CompanyTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Company Type.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/company-types/{id}
     * @routeParam {id} required
     * @param UpdateCompanyTypeRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateCompanyTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateCompanyTypeDTO::fromRequest($request);
            $this->companyTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Company Type updated successfully.",
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
            $this->logError($e, 'CompanyTypeController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Company Type.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/company-types/check
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);

            $exists = $this->companyTypeService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CompanyTypeController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
