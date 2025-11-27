<?php

declare(strict_types=1);

namespace App\Http\Controllers\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponses
{
    /**
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
            'data' => $data,
            'message' => $message,
            'meta' => array_merge([
                'timestamp' => now()->toIso8601String(),
                'version' => 'v1',
            ], $additionalMeta),
        ], $statusCode);
    }

    /**
     * @param array<string, mixed>|null $details
     */
    protected function errorResponse(
        string $code,
        string $message,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        ?array $details = null,
    ): JsonResponse {
        $error = [
            'code' => $code,
            'message' => $message,
        ];

        if ($details !== null) {
            $error['details'] = $details;
        }

        return response()->json([
            'success' => false,
            'error' => $error,
            'meta' => [
                'timestamp' => now()->toIso8601String(),
                'correlationId' => request()->header('X-Correlation-ID'),
            ],
        ], $statusCode);
    }

    /**
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \Illuminate\Database\Eloquent\Model> $paginator
     * @return array<string, mixed>
     */
    protected function getPaginationMeta($paginator): array
    {
        return [
            'pagination' => [
                'currentPage' => $paginator->currentPage(),
                'perPage' => $paginator->perPage(),
                'total' => $paginator->total(),
                'lastPage' => $paginator->lastPage(),
            ],
        ];
    }

    /**
     * @param \Illuminate\Contracts\Pagination\LengthAwarePaginator<int, \Illuminate\Database\Eloquent\Model> $paginator
     * @return array<string, string|null>
     */
    protected function getPaginationLinks($paginator): array
    {
        return [
            'first' => $paginator->url(1),
            'last' => $paginator->url($paginator->lastPage()),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
        ];
    }
}
