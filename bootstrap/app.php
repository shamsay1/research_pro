<?php

use App\Http\Middleware\CheckAuthentication;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'auth.check' => CheckAuthentication::class,
            'role'       => CheckRole::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {

        // Redirect 419 Page Expired to Login Page
        $exceptions->render(function (
            TokenMismatchException $e,
            $request
        ) {
            return redirect()
                ->route('login1')
                ->with(
                    'error',
                    'This service was in restriction,please login again'
                );
        });

    })

    ->create();