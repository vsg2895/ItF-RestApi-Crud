<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                $exceptionClassName = substr(get_class($e), strrpos(get_class($e), '\\') + 1);
                return match ($exceptionClassName) {
                    'NotFoundHttpException' => Response::fail(new NotFoundHttpException(), 'Not Found', 404),
                    'MethodNotAllowedHttpException' => Response::fail(new \Exception(), 'Not Allowed', 405),
                    'AuthenticationException' => Response::fail(new \Exception(), 'Unauthenticated'),
                    default => Response::fail($e),
                };
            }
            return $request->expectsJson();
        });
    })->create();
