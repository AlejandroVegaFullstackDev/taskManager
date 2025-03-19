<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Tymon\JWTAuth\Http\Middleware\Authenticate as JWTAuthMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', 
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registras tus aliases en un arreglo asociativo
        $middleware->alias([
            'jwt.verify' => JWTAuthMiddleware::class,
            'jwt.refresh' => JWTRefreshMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
