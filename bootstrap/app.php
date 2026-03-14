<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->append(\App\Http\Middleware\DetectReseller::class);
        $middleware->prependToGroup('web', \App\Http\Middleware\RedirectIfInstalled::class);

        $middleware->validateCsrfTokens(except: [
            'install/*',
            'install',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
