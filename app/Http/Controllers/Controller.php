<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    /**
     * Unified JSON response method.
     *
     * @param  string       $status   'success' | 'error' | 'fail'
     * @param  string       $message  Human-readable message
     * @param  mixed        $data     Response payload (array, object, or null)
     * @param  mixed        $id       Resource ID (e.g. after create), optional
     * @param  mixed        $errors   Validation / error detail, optional
     * @param  int          $code     HTTP status code (default: 200)
     * @return JsonResponse
     */
    protected function jsonResponse(
        string $status = 'success',
        string $message = '',
        mixed  $data    = null,
        mixed  $id      = null,
        mixed  $errors  = null,
        int    $code    = 200
    ): JsonResponse {
        $payload = [
            'status'  => $status,
            'message' => $message,
        ];

        if (!is_null($id)) {
            $payload['id'] = $id;
        }

        if (!is_null($data)) {
            $payload['data'] = $data;
        }

        if (!is_null($errors)) {
            $payload['errors'] = $errors;
        }

        return response()->json($payload, $code);
    }

    /**
     * Log an exception with controller context.
     *
     * @param  \Throwable  $e
     * @param  string      $context  e.g. 'CountryController@index'
     * @param  array       $extra    Additional context data (payload, id, etc.)
     */
    protected function logError(\Throwable $e, string $context = '', array $extra = []): void
    {
        Log::error("[{$context}] " . $e->getMessage(), array_merge($extra, [
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]));
    }
}
