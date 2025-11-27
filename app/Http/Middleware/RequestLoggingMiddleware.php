<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class RequestLoggingMiddleware
{
    private const SENSITIVE_HEADERS = [
        'authorization',
        'cookie',
        'x-api-key',
    ];

    private const SENSITIVE_FIELDS = [
        'password',
        'password_confirmation',
        'token',
        'secret',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        $response = $next($request);

        $this->logRequest(
            $request,
            $response,
            microtime(true) - $startTime,
            memory_get_usage() - $startMemory,
        );

        return $response;
    }

    private function logRequest(
        Request $request,
        Response $response,
        float $executionTime,
        int $memoryUsage,
    ): void {
        RequestLog::create([
            'correlation_id' => $request->header('X-Correlation-ID') ?? Str::uuid()->toString(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'route_name' => $request->route()?->getName(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'request_headers' => $this->sanitizeHeaders($request->headers->all()),
            'request_body' => $this->sanitizeBody($request->all()),
            'response_status' => $response->getStatusCode(),
            'response_body' => $this->truncateResponseBody($response->getContent()),
            'execution_time' => round($executionTime, 4),
            'memory_usage' => $memoryUsage,
        ]);
    }

    /**
     * @param array<string, mixed> $headers
     * @return array<string, mixed>
     */
    private function sanitizeHeaders(array $headers): array
    {
        foreach (self::SENSITIVE_HEADERS as $sensitive) {
            if (isset($headers[$sensitive])) {
                $headers[$sensitive] = '[REDACTED]';
            }
        }

        return $headers;
    }

    /**
     * @param array<string, mixed> $body
     * @return array<string, mixed>
     */
    private function sanitizeBody(array $body): array
    {
        foreach (self::SENSITIVE_FIELDS as $field) {
            if (isset($body[$field])) {
                $body[$field] = '[REDACTED]';
            }
        }

        return $body;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function truncateResponseBody(string|false $content): ?array
    {
        if ($content === false || $content === '') {
            return null;
        }

        /** @var array<string, mixed>|null $decoded */
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return null;
        }

        return $decoded;
    }
}
