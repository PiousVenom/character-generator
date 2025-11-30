<?php

declare(strict_types=1);

use App\Http\Middleware\CorrelationId;
use App\Http\Middleware\RequestLogging;
use App\Models\ErrorLog;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(static function (Middleware $middleware): void {
        $middleware->prepend(CorrelationId::class);
        $middleware->append(RequestLogging::class);
    })
    ->withExceptions(static function (Exceptions $exceptions): void {
        $exceptions->render(static function (Throwable $exception, Request $request): ?Response {
            $correlationId = CorrelationId::getId() ?? Illuminate\Support\Str::uuid()->toString();

            ErrorLog::create([
                'correlation_id'    => $correlationId,
                'level'             => 'error',
                'message'           => $exception->getMessage(),
                'exception_class'   => $exception::class,
                'exception_message' => $exception->getMessage(),
                'exception_code'    => (string) $exception->getCode(),
                'exception_file'    => $exception->getFile(),
                'exception_line'    => $exception->getLine(),
                'exception_trace'   => app()->hasDebugModeEnabled() ? $exception->getTraceAsString() : null,
                'context'           => [
                    'request_id' => $correlationId,
                ],
                'url'         => $request->fullUrl(),
                'method'      => $request->method(),
                'user_agent'  => $request->userAgent(),
                'ip_address'  => $request->ip(),
                'occurred_at' => now(),
            ]);

            return null;
        });
    })->create();
