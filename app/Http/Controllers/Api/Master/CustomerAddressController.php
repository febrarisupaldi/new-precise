<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\CustomerAddress\{CreateCustomerAddressDTO, UpdateCustomerAddressDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\CustomerAddress\{CreateCustomerAddressRequest, UpdateCustomerAddressRequest};
use App\Services\Master\CustomerAddressService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerAddressController extends Controller
{
    private CustomerAddressService $customerAddressService;

    public function __construct(CustomerAddressService $customerAddressService)
    {
        $this->customerAddressService = $customerAddressService;
    }

    /**
     * GET /api/master/customer-addresses
     * 
     * - Behavior:
     *   - Return all customer address data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @return StreamedResponse
     */
    public function index(): StreamedResponse
    {
        try {
            return $this->streamJsonResponse(
                function (&$first) {

                    $this->customerAddressService->index(
                        function ($row) use (&$first) {

                            if (!$first) {
                                echo ',';
                            }

                            echo json_encode($row);

                            $first = false;
                        }
                    );
                },
                'Customer Address retrieved successfully.'
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CustomerAddressController@index');

            return $this->streamJsonResponse(
                function () {},
                'Failed to retrieve Customer Address list.'
            );
        }
    }

    /**
     * GET /api/master/customer-addresses/{id}
     * 
     * - Behavior:
     *   - Return single customer address data based on id
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer Address retrieved successfully.',
                data: $this->customerAddressService->show($id),
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'failed',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CustomerAddressController@find');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Customer Address.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/customer-addresses
     * 
     * - Behavior:
     *   - Create single customer address data
     * 
     * - Body:
     *   - customer_id required, example: 1
     *   - address_line_1 required, example: "Address Line 1"
     *   - address_line_2 optional, example: "Address Line 2"
     *   - city required, example: "City"
     *   - state_id required, example: 1
     *   - postal_code optional, example: "12345"
     *   - country_id required, example: 1
     *   - phone required, example: "1234567890"
     *   - email optional, example: "[EMAIL_ADDRESS]"
     *   - is_billing required, example: true
     *   - is_shipping required, example: true
     *   - created by required, example: "Supaldi"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  CreateCustomerAddressRequest  $request
     * @return JsonResponse
     */
    public function store(CreateCustomerAddressRequest $request)
    {
        try {
            $dto = CreateCustomerAddressDTO::fromRequest($request);
            $result = $this->customerAddressService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer Address created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CustomerAddressController@create');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Customer Address.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/customer-addresses/{id}
     * 
     * - Behavior:
     *   - Update single customer address data based on id
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Body:
     *   - customer_id optional, example: 1
     *   - address_line_1 optional, example: "Address Line 1"
     *   - address_line_2 optional, example: "Address Line 2"
     *   - city optional, example: "City"
     *   - state_id optional, example: 1
     *   - postal_code optional, example: "12345"
     *   - country_id optional, example: 1
     *   - phone optional, example: "1234567890"
     *   - email optional, example: "[EMAIL_ADDRESS]"
     *   - is_billing optional, example: true
     *   - is_shipping optional, example: true
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Updated description"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  UpdateCustomerAddressRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateCustomerAddressRequest $request, int $id): JsonResponse
    {
        try {
            $dto = UpdateCustomerAddressDTO::fromRequest($request);
            $this->customerAddressService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer Address updated successfully.',
                data: $dto->toArray(),
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CustomerAddressController@update');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Customer Address.',
                code: 500
            );
        }
    }

    /**
     * DELETE /api/master/customer-addresses/{id}
     * 
     * - Behavior:
     *   - Delete single customer address data based on id
     * 
     * - Path:
     *   - id required, example: 1
     * 
     * - Body:
     *   - updated_by required, example: "Supaldi"
     *   - reason required, example: "updated description"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  int  $id
     * @param  DeleteRequest  $request
     * @return JsonResponse
     */
    public function delete(int $id, DeleteRequest $request): JsonResponse
    {
        try {
            $this->customerAddressService->delete($id, $request->toArray());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer Address deleted successfully.',
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'CustomerAddressController@delete');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to delete Customer Address.',
                code: 500
            );
        }
    }
}
