<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    //los usuarios son redirigidos aquí después de iniciar sesión
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        //límite de solicitudes para la API 60 por minuto por usuario o IP
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            //agrupa las rutas api con prefijo /api, archivo de rutas y su middleware
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            //rutas web con middleware 'web'
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}