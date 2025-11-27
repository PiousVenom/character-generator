<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Models\ErrorLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

final class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): Response
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->renderApiException($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function renderApiException($request, Throwable $e): JsonResponse
    {
        $correlationId = $request->header('X-Correlation-ID') ?? Str::uuid()->toString();

        if ($e instanceof ValidationException) {
            return $this->validationErrorResponse($e, $correlationId);
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return $this->notFoundResponse($correlationId);
        }

        // Log unexpected errors
        $this->logError($e, $correlationId);

        return $this->internalErrorResponse($correlationId);
    }

    private function validationErrorResponse(ValidationException $e, string $correlationId): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'VALIDATION_ERROR',
                'message' => 'The given data was invalid.',
                'details' => $e->errors(),
            ],
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'correlationId' => $correlationId,
            ],
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function notFoundResponse(string $correlationId): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'NOT_FOUND',
                'message' => 'The requested resource was not found.',
            ],
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'correlationId' => $correlationId,
            ],
        ], Response::HTTP_NOT_FOUND);
    }

    private function internalErrorResponse(string $correlationId): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => 'INTERNAL_ERROR',
                'message' => 'An unexpected error occurred.',
            ],
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'correlationId' => $correlationId,
            ],
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    private function logError(Throwable $e, string $correlationId): void
    {
        try {
            ErrorLog::create([
                'correlation_id' => $correlationId,
                'exception_class' => get_class($e),
                'message' => $e->getMessage(),
                'code' => (string) $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'severity' => 'error',
                'context' => [
                    'url' => request()->fullUrl(),
                    'method' => request()->method(),
                    'input' => request()->except(['password', 'token']),
                ],
                'occurred_at' => now(),
            ]);
        } catch (Throwable) {
            // Fail silently - don't break the app if logging fails
        }
    }
}
