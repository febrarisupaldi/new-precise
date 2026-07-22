<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\UOM\{CreateUOMDTO, UpdateUOMDTO};
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\UOM\{CreateUOMRequest, UpdateUOMRequest};
use App\Services\Master\UOMService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|UOM', 'UOMs')]
class UOMController extends Controller
{
    private UOMService $uomService;

    public function __construct(UOMService $uomService)
    {
        $this->uomService = $uomService;
    }

    /**
     * GET /api/master/uoms
     * 
     * Behavior:
     *  - get all uoms
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $uoms = $this->uomService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'UOM list retrieved successfully.',
                data: $uoms,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'UOMController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve UOM list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/uoms/{id}
     * 
     * Behavior:
     *  - get uom by id
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        try {
            $uom = $this->uomService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'UOM retrieved successfully.',
                data: $uom,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'UOMController@show', ['id' => $id]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve UOM.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/uoms
     * 
     * Behavior:
     *  - create uom
     * 
     * Body:
     *  - uom code required, example: "KG"
     *  - uom name required, example: "Kilogram"
     *  - uom coretax required, example: "UM.0021"
     *  - is active optional, example: true
     *  - created by required, example: "admin"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param CreateUOMRequest $request
     * @return JsonResponse
     */
    public function store(CreateUOMRequest $request): JsonResponse
    {
        try {
            $dto = CreateUOMDTO::fromRequest($request);
            $id = $this->uomService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'UOM created successfully.',
                data: $dto->toArray(),
                id: $id,
                code: 201
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 404
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'UOMController@store', ['payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create UOM.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/uoms/{id}
     * 
     * Behavior:
     *  - update uom
     * 
     * Path:
     *  - id required, example: 1
     * 
     * Body:
     *  - uom code optional, example: "KG"
     *  - uom name optional, example: "Kilogram"
     *  - uom coretax optional, example: "UM.0021"
     *  - is active optional, example: true
     *  - updated by required, example: "admin"
     *  - reason required, example: "Updated description"
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param UpdateUOMRequest $request
     * @routeParam {id} required
     * @return JsonResponse
     */
    public function update(string $id, UpdateUOMRequest $request): JsonResponse
    {
        try {
            $dto = UpdateUOMDTO::fromRequest($request);
            $this->uomService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'UOM updated successfully.',
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
            $this->logError($e, 'UOMController@update', ['id' => $id, 'payload' => $request->all()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update UOM.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/uoms/check
     * 
     * Behavior:
     *  - check if uom exists
     * 
     * Business Rules:
     *  - columns and values required and must be same length
     * 
     * Query Parameters:
     *  - columns[] required, example: ["uom_code"]
     *  - values[] required, example: ["KG"]
     * 
     * Authentication:
     *  - Requires valid bearer token
     * 
     * @param ExistsRequest $request
     * @return JsonResponse
     */
    public function check(ExistsRequest $request): JsonResponse
    {
        try {
            $dto = ExistsDTO::fromRequest($request);

            $exists = $this->uomService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'UOMController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
