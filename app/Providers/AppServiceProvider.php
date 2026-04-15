<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Auth\DatabaseJwtUserProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Auth::provider('database_jwt', function ($app, array $config) {
            $connection = $app['db']->connection($config['connection'] ?? null);

            return new DatabaseJwtUserProvider($connection, $app['hash'], $config['table']);
        });

        // Log setiap query database ke file laravel.log
        \Illuminate\Support\Facades\DB::listen(function ($query) {
            $sql = $query->sql;
            foreach ($query->bindings as $binding) {
                $value = is_string($binding) ? "'$binding'" : $binding;
                // Ganti tanda tanya (?) dengan nilai binding yang sesuai
                $sql = preg_replace('/\?/', $value, $sql, 1);
            }

            \Illuminate\Support\Facades\Log::info("[DB QUERY] ({$query->time}ms) {$sql}");
        });
    }
}
