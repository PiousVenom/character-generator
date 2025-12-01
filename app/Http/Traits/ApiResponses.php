<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Http\Middleware\CorrelationId;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Provides standardized API response formatting.
 *
 * All API responses follow a consistent envelope structure
 * as defined in API_STANDARDS.md.
 */
trait ApiResponses
{
    /**
     * Return a created response (201).
     *
     * @param array<string, mixed> $additionalMeta
     */
    protected function createdResponse(
        mixed $data,
        string $message = 'Created successfully',
        array $additionalMeta = [],
    ): JsonResponse {
        return $this->successResponse(
            $data,
            $message,
            Response::HTTP_CREATED,
            $additionalMeta,
        );
    }

    /**
     * Return an error response.
     *
     * @param array<string, mixed>|null $details
     */
    protected function errorResponse(
        string $code,
        string $message,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        ?array $details = null,
    ): JsonResponse {
        $error = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($details !== null) {
            $error['details'] = $details;
        }

        return response()->json([
            'success' => false,
            'error'   => $error,
            'meta'    => [
                'timestamp'     => now()->toIso8601String(),
                'correlationId' => CorrelationId::getId(),
            ],
        ], $statusCode);
    }

    /**
     * Return a no content response (204).
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Return a not found error response (404).
     */
    protected function notFoundResponse(
        string $message = 'Resource not found',
    ): JsonResponse {
        return $this->errorResponse(
            'NOT_FOUND',
            $message,
            Response::HTTP_NOT_FOUND,
        );
    }

    /**
     * Return a successful response.
     *
     * @param array<string, mixed> $additionalMeta
     */
    protected function successResponse(
        mixed $data,
        string $message = 'Operation successful',
        int $statusCode = Response::HTTP_OK,
        array $additionalMeta = [],
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
            'meta'    => array_merge([
                'timestamp' => now()->toIso8601String(),
                'version'   => 'v1',
            ], $additionalMeta),
        ], $statusCode);
    }

    /**
     * Return a validation error response (422).
     *
     * @param array<string, array<int, string>> $errors
     */
    protected function validationErrorResponse(
        array $errors,
        string $message = 'The given data was invalid.',
    ): JsonResponse {
        return $this->errorResponse(
            'VALIDATION_ERROR',
            $message,
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $errors,
        );
    }
}
