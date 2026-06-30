<?php

namespace App\Http\Controllers\Api\Master;

use App\DTOs\ExistsDTO;
use App\DTOs\Master\ColorType\CreateColorTypeDTO;
use App\DTOs\Master\ColorType\UpdateColorTypeDTO;
use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ExistsRequest;
use App\Http\Requests\Master\ColorType\CreateColorTypeRequest;
use App\Http\Requests\Master\ColorType\UpdateColorTypeRequest;
use App\Services\Master\ColorTypeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColorTypeController extends Controller
{
    protected ColorTypeService $colorTypeService;

    public function __construct(ColorTypeService $colorTypeService)
    {
        $this->colorTypeService = $colorTypeService;
    }

    /**
     * GET /api/master/color-types
     * 
     * - Behavior:
     *   - Return all color type data
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->colorTypeService->all();

            return $this->jsonResponse(
                status: 'ok',
                message: 'Color Type list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ColorTypeController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Color Type list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/color-types/{id}
     * 
     * - Behavior:
     *   - Return single color type data based on id
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
            $result = $this->colorTypeService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Color Type retrieved successfully.',
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
            $this->logError($e, 'ColorTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Color Type.',
                code: 500
            );
        }
    }

    /**
     * POST /api/master/company-types
     * 
     * - Behavior:
     *   - Create single color type data
     * 
     * - Business rules:
     *   - color type name required and unique, example: "Color Name"
     *   - color type code required and unique, example: "CT"
     *   - created by required
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @param CreateColorTypeRequest $request
     * @return JsonResponse
     */
    public function store(CreateColorTypeRequest $request): JsonResponse
    {
        try {
            $dto    = CreateColorTypeDTO::fromRequest($request);
            $result = $this->colorTypeService->create($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Color Type created successfully.',
                data: $dto->toArray(),
                id: $result,
                code: 201
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ColorTypeController@store', ['payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to create Color Type.',
                code: 500
            );
        }
    }

    /**
     * PUT /api/master/company-types/{id}
     * 
     * - Behavior:
     *   - Update single color type data based on id
     * 
     * - Business Rules:
     *   - color type name required and unique, example: "Color Name"
     *   - color type code required and unique, example: "CT"
     *   - updated by required, example: "Supaldi"
     *   - reason required, example: "Testing"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param UpdateColorTypeRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateColorTypeRequest $request): JsonResponse
    {
        try {
            $dto = UpdateColorTypeDTO::fromRequest($request);
            $this->colorTypeService->update($id, $dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Color Type updated successfully.",
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
            $this->logError($e, 'ColorTypeController@update', ['id' => $id, 'payload' => $request->all()]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update Color Type.',
                code: 500
            );
        }
    }

    /**
     * Delete a Color Type
     * 
     * - Behavior:
     *   - Delete single color type data based on id
     * 
     * - Business Rules:
     *   - If there is a color type data that uses this color type, then it cannot be deleted.
     *   - reason required, example: "Only testing purposes"
     * 
     * - Authentication:
     *   - Requires valid bearer Token
     * 
     * @routeParam {id} required
     * @param DeleteRequest $request
     * @return JsonResponse
     */
    public function delete(int $id, DeleteRequest $request): JsonResponse
    {
        try {
            $this->colorTypeService->delete($id, $request->toArray());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Color Type deleted successfully.',
                data: $request->toArray(),
                id: $id,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'fail',
                message: $e->getMessage(),
                code: 400
            );
        } catch (\Throwable $th) {
            $this->logError($th, 'ColorTypeController@delete');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to update warehouse.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/color-types/check
     * 
     * - Behavior:
     *   - Check if data already exists
     * 
     * - Available Request:
     *   - GET /api/master/color-types/check?columns[]=color_type_name&values[]=test
     *   - GET /api/master/color-types/check?columns[]=color_type_code&values[]=test
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

            $exists = $this->colorTypeService->checkExist($dto);

            return $this->jsonResponse(
                status: 'ok',
                message: "Check completed.",
                data: [
                    'exists' => $exists
                ],
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ColorTypeController@check', ['query' => $request->query()]);
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to perform check.',
                code: 500
            );
        }
    }
}
