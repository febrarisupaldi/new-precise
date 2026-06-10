<?php

namespace App\Http\Controllers\Api\Master;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Services\Master\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index():JsonResponse{
        try{
            $result = $this->customerService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer retrieved successfully.',
                data: $result,
                code: 200
            );
        }catch(BadRequestException $e){
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        }catch(\Throwable $e){
            $this->logError($e, 'CustomerController@index', []);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve customer.',
                code: 500
            );
        }
    }

    public function show(int $id): JsonResponse{
        try{
            $result = $this->customerService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Customer retrieved successfully.',
                data: $result,
                code: 200
            );
        }catch(BadRequestException $e){
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        }catch(\Throwable $e){
            $this->logError($e, 'CustomerController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve customer.',
                code: 500
            );
        }
    }

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
