<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(\App\Http\Middleware\ObserveRequests::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->context(fn () => [
            'request_id' => request()?->attributes->get('request_id'),
            'route_name' => request()?->route()?->getName(),
            'request_path' => request()?->path(),
            'release' => env('APP_RELEASE'),
        ]);

        $exceptions->render(function (TooManyRequestsHttpException $e, $request) {
            if ($request->route()?->getName() === 'talk-to-us.store') {
                return back()
                    ->withErrors([
                        'form' => 'Too many messages were sent from this connection. Please wait a minute and try again.',
                    ])
                    ->setStatusCode(429);
            }
        });
    })->create();
