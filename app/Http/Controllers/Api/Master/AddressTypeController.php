<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\Http\Controllers\Controller;
use App\Services\Master\AddressTypeService;
use App\DTOs\Master\AddressType\{CreateAddressTypeDTO, UpdateAddressTypeDTO};
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\AddressType\{CreateAddressTypeRequest, UpdateAddressTypeRequest};
use Illuminate\Http\JsonResponse;
use App\Exceptions\BadRequestException;
use Dedoc\Scramble\Attributes\Group;

#[Group('Master', 'Address Types')]
class AddressTypeController extends Controller
{
    protected AddressTypeService $addressTypeService;

    public function __construct(AddressTypeService $addressTypeService)
    {
        $this->addressTypeService = $addressTypeService;
    }

    /**
     * GET /api/master/address-types
     * 
     * - Behavior:
     *   - Return all address type data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->addressTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Address Type list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'AddressTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Address Type list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/address-types/{id}
     * 
     * - Behavior:
     *   - Return single address type data based on id
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
            $result = $this->addressTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Address Type retrieved successfully.',
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
            $this->logError($e, 'AddressTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Address Type.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/address-types
     * 
     * - Behavior:
     *   - Create single address type data
     * 
     * - Body:
     *   - address type name required, example: "Billing Address", "Shipping Address", "Billing and Shipping Address", "Other"
     *   - address type description nullable
     *   - created by will using logged in user
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateAddressTypeRequest $request
     * @return JsonResponse
     */
    public function store(CreateAddressTypeRequest $request): JsonResponse
    {
        try {
            $dto    = CreateAddressTypeDTO::fromRequest($request);
            $result = $this->addressTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Address Type created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'AddressTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Address Type.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/address-types/{id}
     * 
     * - Behavior:
     *   - Update single address type data
     * 
     * - Body:
     *   - address type name required, example: "Billing Address", "Shipping Address", "Billing and Shipping Address", "Other"
     *   - address type description nullable, example: "Description"
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Testing"
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateAddressTypeRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateAddressTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateAddressTypeDTO::fromRequest($request);
            $this->addressTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Address Type updated successfully.",
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
            $this->logError($e, 'AddressTypeController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Address Type.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/address-types/check
     * 
     * - Behavior:
     *   - Check if data already exists
     * 
     * - Business Rules:
     *   - columns and values required and must be same length
     * 
     * - Query Parameters:
     *   - columns[] required, example: ["address_type_name"]
     *   - values[] required, example: ["test"]
     * 
     * - Available Request:
     *   - /api/master/address-types/check?columns[]=address_type_name&values[]=test
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

            $exists = $this->addressTypeService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'AddressTypeController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
