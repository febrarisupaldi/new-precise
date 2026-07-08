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
     * GET /api/master/uoms/check
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
