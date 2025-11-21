<?php

use App\Http\Middleware\TokenApi;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    //configura el enrutamiento de la aplicación en Laravel 12 se realiza aquí por cambios del framework
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //registro de middleware
        $middleware->alias([
            'token.api' => TokenApi::class,
        ]);
    })
    //configuración específica de manejo de excepciones
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
