<?php

namespace App\Http\Controllers\Api\Master;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Services\Master\ProductService;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

#[Group('MASTER|Product', 'Product')]
class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): StreamedResponse
    {
        try {
            return $this->streamJsonResponse(
                function (&$first) {

                    $this->productService->stream(
                        function ($row) use (&$first) {

                            if (!$first) {
                                echo ',';
                            }

                            echo json_encode($row);

                            $first = false;
                        }
                    );
                },
                'Product list retrieved successfully.'
            );
        } catch (\Throwable $e) {
            $this->logError($e, 'ProductController@index');

            return $this->streamJsonResponse(
                function () {},
                'Failed to retrieve Product list.'
            );
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $result = $this->productService->find($id);

            return $this->jsonResponse(
                status: 'ok',
                message: 'Product retrieved successfully.',
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
            $this->logError($e, 'RetailTypeController@show', ['id' => $id]);

            return $this->jsonResponse(
                status: 'error',
                message: 'Failed to retrieve Retail Type.',
                code: 500
            );
        }
    }
}
