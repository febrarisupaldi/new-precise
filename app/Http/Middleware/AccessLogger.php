<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccessLogger
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
        $response = $next($request);

        // Pencatatan dilakukan SETELAH request selesai diproses 
        // agar kita bisa menangkap User ID jika user sedang login via JWT
        try {
            DB::table('access_logs')->insert([
                'user_id'    => Auth::guard('api')->check() ? Auth::guard('api')->user()->getAuthIdentifier() : null,
                'url'        => $request->fullUrl(),
                'method'     => $request->method(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Kita bungkus try-catch agar jika ada masalah di tabel log, 
            // aplikasi utama tetap berjalan lancar.
            Log::error('Gagal mencatat access log: ' . $e->getMessage());
        }

        return $response;
    }
}
