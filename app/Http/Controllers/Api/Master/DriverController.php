<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\Master\Driver\{CreateDriverDTO, UpdateDriverDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Driver\{CreateDriverRequest, UpdateDriverRequest};
use App\Services\Master\DriverService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

#[Group("Master|Driver", "Driver")]
class DriverController extends Controller
{
    private DriverService $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * GET /api/master/drivers
     * 
     * Behavior: 
     *  - Return all driver data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $result = $this->driverService->all();
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Driver list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'DriverController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve driver data.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/drivers/{id}
     * 
     * Behavior: 
     *  - Return specific driver data
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $result = $this->driverService->find($id);
        try {
            return $this->jsonResponse(
                status: 'ok',
                message: 'Driver data retrieved successfully.',
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
            $this->logError($e, 'DriverController@show');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve driver data.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/drivers
     * 
     * Behavior: 
     *  - Create single driver data
     * 
     * Body:
     *  - driver nik required string
     *  - created by required string
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param CreateDriverRequest $request
     * @return JsonResponse
     */
    public function store(CreateDriverRequest $request): JsonResponse
    {
        try {
            $dto = CreateDriverDTO::fromRequest($request);
            $result = $this->driverService->create($dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Driver created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'DriverController@store', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create driver.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/drivers/{id}
     * 
     * Behavior: 
     *  - Update single driver data
     * 
     * Body:
     *  - updated by required string
     *  - is active required boolean
     *  - reason required string
     * 
     * Authentication: 
     *  - Requires valid bearer token
     * 
     * @param int $id
     * @param UpdateDriverRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateDriverRequest $request): JsonResponse
    {
        try {
            $dto = UpdateDriverDTO::fromRequest($request);
            $this->driverService->update($id, $dto);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Driver updated successfully.',
                data: $dto->toArray(),
                id: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'DriverController@update', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update driver.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/drivers/check
     * 
     * Behavior: 
     *  - Check if driver NIK already exists
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
            $result = $this->driverService->checkExist($request->all());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Driver NIK checked successfully.',
                data: [
                    'is_exists' => $result
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'DriverController@check', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to check driver NIK.',
                code: 500
            );
        }
    }
}
