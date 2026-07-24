<?php

namespace App\Http\Controllers\Api\Master;


use App\Http\Controllers\Controller;
use App\Services\Master\CompanyTypeService;
use App\DTOs\Master\CompanyType\{CreateCompanyTypeDTO, UpdateCompanyTypeDTO};
use Illuminate\Http\Request;
use App\Http\Requests\Master\CompanyType\{CreateCompanyTypeRequest, UpdateCompanyTypeRequest};
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Company Type', 'Company Type')]
class CompanyTypeController extends Controller
{
    protected CompanyTypeService $companyTypeService;

    public function __construct(CompanyTypeService $companyTypeService)
    {
        $this->companyTypeService = $companyTypeService;
    }

    /**
     * GET /api/master/company-types
     * 
     * Behavior:
     *   - Return all company type data
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *   - Return single company type data based on id
     * 
     * Path:
     *   - id required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *   - Create single company type data
     * 
     * Body:
     *   - company type name required, example: "Company Type Name"
     *   - company type description optional, example: "CT"
     *   - created by required, example: "Supaldi"
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *   - Update single company type data based on id
     * 
     * Body:
     *   - company type name optional, example: "Company Type Name"
     *   - company type description optional, example: "CT"
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Updated description"
     * 
     * Path:
     *   - id required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
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
     * 
     * Behavior:
     *   - Check if data already exists
     * 
     * Business Rules:
     *   - columns and values required and must be same length
     * 
     * Query Parameters:
     *   - columns[] required, example: ["company_type_name"]
     *   - values[] required, example: ["test"]
     * 
     * Available Request:
     *   - GET /api/master/company-types/check?columns[]=company_type_code&values[]=test
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {


            $exists = $this->companyTypeService->checkExist($request->query());

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
