<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogViewerJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil token dari Query string (?token=...), Cookie, atau Header Bearer
        $token = $request->query('token') ?: $request->cookie('jwt_log_token') ?: $request->bearerToken();

        if (!$token) {
            return response('Akses ditolak: Token JWT tidak ditemukan. Tambahkan parameter ?token= di URL.', 401);
        }

        try {
            // Gunakan facade JWTAuth langsung agar lebih robust
            $user = JWTAuth::setToken($token)->authenticate();
        } catch (\Exception $e) {
            return response('Akses ditolak: Token JWT tidak valid atau sudah kadaluarsa. Error: ' . $e->getMessage(), 401);
        }

        // Lanjut ke request jika sukses
        $response = $next($request);

        // Jika URL memiliki parameter ?token=, kita simpan tokennya ke dalam Cookie.
        if ($request->has('token')) {
            $response->cookie('jwt_log_token', $token, 120, '/', null, false, false);
        }

        return $response;
    }
}
