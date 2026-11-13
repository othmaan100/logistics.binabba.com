<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Send admins to the first-run setup until the organization's details are saved
        $middleware->web(append: \App\Http\Middleware\EnsureOrganizationIsSetUp::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // GPS trackers rarely send "Accept: application/json"; answer /api errors in JSON anyway
        $exceptions->shouldRenderJsonWhen(fn ($request) => $request->is('api/*'));
    })->create();
