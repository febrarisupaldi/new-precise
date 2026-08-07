<?php

namespace App\Http\Controllers\Api\Master;


use App\DTOs\Master\Vehicle\{CreateVehicleDTO, UpdateVehicleDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Master\Vehicle\{CreateVehicleRequest, UpdateVehicleRequest};
use App\Services\Master\VehicleService;
use Illuminate\Http\JsonResponse;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Vehicle', 'Vehicles')]
class VehicleController extends Controller
{
    protected VehicleService $vehicleService;

    public function __construct(VehicleService $vehicleService)
    {
        $this->vehicleService = $vehicleService;
    }

    /**
     * GET /api/master/vehicles
     * 
     * Behavior:
     *  - get all vehicles
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Data fetched successfully',
                data: $this->vehicleService->all($request->toArray()),
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
     * GET /api/master/vehicles/{id}
     * 
     * Behavior:
     *  - get vehicle by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer token
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

    /**
     * POST /api/master/vehicles
     * 
     * Behavior:
     *  - create vehicle
     * 
     * Body:
     *  - vehicle model optional, example: "MOTOR"
     *  - license number required, example: "B 1234 XYZ"
     *  - vehicle description optional, example: "test"
     *  - is owned optional, example: true
     *  - is active optional, example: true
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param CreateVehicleRequest $request
     * @return JsonResponse
     */
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

    /**
     * PUT /api/master/vehicles/{id}
     * 
     * Behavior:
     *  - update vehicle
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - vehicle model optional, example: "MOTOR"
     *  - license number required, example: "B 1234 XYZ"
     *  - vehicle description optional, example: "test"
     *  - is owned optional, example: true
     *  - is active optional, example: true
     *  - updated by required, example: "admin"
     *  - reason optional, example: "Updated description"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @routeParam {id} required
     * @param UpdateVehicleRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateVehicleRequest $request): JsonResponse
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

    /**
     * GET /api/master/vehicles/check
     * 
     * Behavior:
     *  - check if vehicle exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["license_number"]
     *  - values[] required, example: ["B 1234 XYZ"]
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        try {

            $exists = $this->vehicleService->checkExist($request->query());

            return $this->jsonResponse(
                status: 'ok',
                message: 'Data is available',
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check data',
                code: 500
            );
        }
    }
}
