<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\Vehicle\CreateVehicleDTO;
use App\DTOs\Master\Vehicle\UpdateVehicleDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Vehicle\CreateVehicleRequest;
use App\Http\Requests\Master\Vehicle\UpdateVehicleRequest;
use App\Services\Master\VehicleService;
use Illuminate\Http\JsonResponse;

class VehicleController extends Controller
{
    protected VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * Get all vehicles
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data fetched successfully',
                data: $this->vehicleService->all(),
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'VehicleController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to fetch data',
                code: 500
            );
        }
    }

    /**
     * Get vehicle by ID
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data fetched successfully',
                data: $this->vehicleService->find($id),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'VehicleController@show');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to fetch data',
                code: 500
            );
        }
    }

    public function findByLicenseNumber(string $licenseNumber): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data fetched successfully',
                data: $this->vehicleService->findByLicenseNumber($licenseNumber),
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'VehicleController@findByLicenseNumber');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to fetch data',
                code: 500
            );
        }
    }


    public function store(CreateVehicleRequest $request): JsonResponse
    {
        try {
            $dto = CreateVehicleDTO::fromRequest($request);
            $result = $this->vehicleService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data created successfully',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'VehicleController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create vehicle.',
                code: 500
            );
        }
    }

    public function update(int $id, UpdateVehicleRequest $request)
    {
        try {
            $dto = UpdateVehicleDTO::fromRequest($request);
            $this->vehicleService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data updated successfully',
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
            $this->logError($e, 'VehicleController@update', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update vehicle.',
                code: 500
            );
        }
    }
}
