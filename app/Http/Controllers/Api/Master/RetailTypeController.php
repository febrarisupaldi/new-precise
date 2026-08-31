<?php

namespace App\Http\Controllers\Api\Master;


use App\Http\Controllers\Controller;
use App\Services\Master\RetailTypeService;
use App\DTOs\Master\RetailType\{CreateRetailTypeDTO, UpdateRetailTypeDTO};
use App\Http\Requests\Master\RetailType\{CreateRetailTypeRequest, UpdateRetailTypeRequest};
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Request;

#[Group('MASTER|Retail Type', 'Retail Types')]
class RetailTypeController extends Controller
{
    protected RetailTypeService $retailTypeService;

    public function __construct(RetailTypeService $retailTypeService)
    {
        $this->retailTypeService = $retailTypeService;
    }

    /**
     * GET /api/master/retail-types
     * 
     * Behavior:
     *   - Return all retail type data
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->retailTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Retail Type list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'RetailTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Retail Type list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/retail-types/{id}
     * 
     * Behavior:
     *   - Return single retail type data based on id
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
            $result = $this->retailTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Retail Type retrieved successfully.',
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
            $this->logError($e, 'RetailTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Retail Type.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/retail-types
     * 
     * Behavior:
     *   - Create single retail type data
     * 
     * Body:
     *   - address type name required, example: "Billing Address", "Shipping Address", "Billing and Shipping Address", "Other"
     *   - address type description nullable
     *   - created by will using logged in user
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateRetailTypeRequest $request
     * @return JsonResponse
     */
    public function store(CreateRetailTypeRequest $request): JsonResponse
    {
        try {
            $dto    = CreateRetailTypeDTO::fromRequest($request);
            $result = $this->retailTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Retail Type created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'RetailTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Retail Type.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/retail-types/{id}
     * 
     * Behavior:
     *   - Update single retail type data
     * 
     * Body:
     *   - address type name required, example: "Billing Address", "Shipping Address", "Billing and Shipping Address", "Other"
     *   - address type description nullable, example: "Description"
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Testing"
     * 
     * Path:
     *   - id required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateRetailTypeRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateRetailTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateRetailTypeDTO::fromRequest($request);
            $this->retailTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Retail Type updated successfully.",
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
            $this->logError($e, 'RetailTypeController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Retail Type.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/retail-types/check
     * 
     * Behavior:
     *   - Check if data already exists
     * 
     * Query Parameters:
     *   - address_type_name required, example: "test"
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
            $exists = $this->retailTypeService->checkExist($request->query());

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'RetailTypeController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
