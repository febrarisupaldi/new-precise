<?php

namespace App\Http\Controllers\Api\Master;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MoldPressing\IndexMoldPressingRequest;
use App\Services\Master\MoldPressingService;
use Illuminate\Http\JsonResponse;
use Dedoc\Scramble\Attributes\Group;

#[Group('MASTER|Mold Pressing', 'Mold Pressings')]
class MoldPressingController extends Controller
{
    private MoldPressingService $moldPressingService;

    public function __construct(MoldPressingService $moldPressingService)
    {
        $this->moldPressingService = $moldPressingService;
    }

    /**
     * GET /api/master/mold-pressings
     * 
     * Behavior:
     * - No parameter: return all mold pressing.
     * - `with=details`: return all mold pressing including details.
     * - `code`: return a mold pressing by code.
     * - `number`: return a mold pressing by number.
     *
     * Restrictions:
     * - `code` and `number` cannot be used together.
     * - `with` cannot be combined with `code` or `number`.
     * 
     * @queryParam code string for mold code. Example: JMB04
     * @queryParam number string for mold number. Example: M.0001
     * @queryParam with string for details data. Example: details
     * 
     * @param IndexMoldPressingRequest $request
     * @return JsonResponse
     */
    public function index(IndexMoldPressingRequest $request): JsonResponse
    {
        try {
            $result = $this->moldPressingService->all($request->validated());
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Pressing list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldPressingController@index');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Mold Pressing list.',
                code: 500
            );
        }
    }

    /**
     * GET /api/master/mold-pressings/{id}
     * @param int $id
     * @return JsonResponse
     */
    public function show(int|string $id): JsonResponse
    {
        try {
            $result = $this->moldPressingService->find($id);
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Pressing data retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (BadRequestException $e) {
            return $this->jsonResponse(
                status: 'error',
                message: $e->getMessage(),
                code: $e->getCode()
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldPressingController@show');

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Mold Pressing data.',
                code: 500
            );
        }
    }
}
