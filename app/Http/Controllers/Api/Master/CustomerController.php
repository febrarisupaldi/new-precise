<?php

namespace App\Http\Controllers\Api\Master;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Services\Master\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Customer', 'Customers')]
class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * GET /api/master/customers
     * 
     * Behavior:
     *   - Return all customer data
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->customerService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer retrieved successfully.',
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
            $this->logError($e, 'CustomerController@index', []);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve customer.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/customers/{id}
     * 
     * Behavior:
     *   - Return single customer data based on id
     * 
     * Path:
     *   - id required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->customerService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer retrieved successfully.',
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
            $this->logError($e, 'CustomerController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve customer.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/customers/{customer_ids}/addresses
     * 
     * Behavior:
     *   - Return single customer data based on id
     * 
     * Path:
     *   - customer_ids required, example: 1
     * 
     * Authentication:
     *   - Requires valid bearer Token
     * 
     * @param  string  $customerIDs
     * @return JsonResponse
     */
    public function findWithAddresses(string $customerIDs): JsonResponse
    {
        try {
            $result = $this->customerService->findWithAddresses($customerIDs);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer Address retrieved successfully.',
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
            $this->logError($e, 'CustomerController@findWithAddresses', ['customer_ids' => $customerIDs]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve customer address.',
                code: 500
            );
        }
    }
}
