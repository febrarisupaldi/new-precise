<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\CustomerAddress\CreateCustomerAddressDTO;
use App\DTOs\Master\CustomerAddress\UpdateCustomerAddressDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\Master\CustomerAddress\CreateCustomerAddressRequest;
use App\Http\Requests\Master\CustomerAddress\UpdateCustomerAddressRequest;
use App\Services\Master\CustomerAddressService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CustomerAddressController extends Controller
{
    private CustomerAddressService $customerAddressService;

    public function __construct(CustomerAddressService $customerAddressService)
    {
        $this->customerAddressService = $customerAddressService;
    }

    /**
     * Get Customer Address list
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
                function () {
                },
                'Failed to retrieve Customer Address list.'
            );
        }
    }

    /**
     * Get Customer Address by ID
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
     * Create Customer Address
     *
     * @param  CreateCustomerAddressRequest  $request
     * @return JsonResponse
     */
    public function store(CreateCustomerAddressRequest $request) {
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
     * Update Customer Address
     *
     * @param  UpdateCustomerAddressRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateCustomerAddressRequest $request, int $id): JsonResponse {
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
     * Delete Customer Address
     *
     * @param  int  $id
     * @param  DeleteRequest  $request
     * @return JsonResponse
     */
    public function delete(int $id, DeleteRequest $request): JsonResponse {
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
