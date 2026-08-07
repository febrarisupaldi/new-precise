<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Services\Master\MoldInjectionService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;

#[Group('MASTER|Mold Injection', 'Mold Injection')]
class MoldInjectionController extends Controller
{
    protected MoldInjectionService $moldInjectionService;

    public function __construct(MoldInjectionService $moldInjectionService)
    {
        $this->moldInjectionService = $moldInjectionService;
    }

    /**
     * GET /api/master/mold-injections
     *
     * Behavior:
     * - Returns all mold injection data.
     *
     * Authentication:
     * - Requires valid bearer token
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $result = $this->moldInjectionService->all();
            return $this->jsonResponse(
                status: 'ok',
                message: 'Mold Injection list retrieved successfully.',
                data: $result,
                code: 200
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'MoldInjectionController@index');
            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Mold Injection list.',
                code: 500
            );
        }
    }
}
