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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.admin' => \App\Http\Middleware\AdminMiddleware::class,
            'auth.wadir1' => \App\Http\Middleware\Wadir1Middleware::class,
            'auth.kaprodi' => \App\Http\Middleware\KaprodiMiddleware::class,
            'auth.tim' => \App\Http\Middleware\TimMiddleware::class,
            'auth.dosen' => \App\Http\Middleware\AuthDosen::class,
            'read.only' => \App\Http\Middleware\ReadOnlyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
