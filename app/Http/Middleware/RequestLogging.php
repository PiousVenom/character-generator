<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function in_array;
use function is_array;

final class RequestLogging
{
    /**
     * Headers to exclude from logging (sensitive data).
     *
     * @var array<int, string>
     */
    private const array EXCLUDED_HEADERS = [
        'authorization',
        'cookie',
        'x-xsrf-token',
        'x-csrf-token',
    ];

    /**
     * Routes to exclude from logging.
     *
     * @var array<int, string>
     */
    private const array EXCLUDED_ROUTES = [
        'password.*',
        'login',
        'logout',
    ];

    /**
     * Request body keys to redact (sensitive data).
     *
     * @var array<int, string>
     */
    private const array REDACTED_KEYS = [
        'password',
        'password_confirmation',
        'current_password',
        'new_password',
        'token',
        'secret',
        'api_key',
        'credit_card',
        'cvv',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $startTime   = microtime(true);
        $startMemory = memory_get_usage();

        /** @var Response $response */
        $response = $next($request);

        if ($this->shouldLog($request)) {
            $this->logRequest($request, $response, $startTime, $startMemory);
        }

        return $response;
    }

    private function logRequest(Request $request, Response $response, float $startTime, int $startMemory): void
    {
        $correlationId = CorrelationId::getId();

        if ($correlationId === null) {
            return;
        }

        RequestLog::create([
            'correlation_id'     => $correlationId,
            'method'             => $request->method(),
            'url'                => $request->fullUrl(),
            'route_name'         => $request->route()?->getName(),
            'ip_address'         => $request->ip(),
            'user_agent'         => $request->userAgent(),
            'request_headers'    => $this->sanitizeHeaders($request->headers->all()),
            'request_body'       => $this->sanitizeBody($request->all()),
            'response_status'    => $response->getStatusCode(),
            'execution_time_ms'  => (microtime(true) - $startTime) * 1000,
            'memory_usage_bytes' => memory_get_usage() - $startMemory,
        ]);
    }

    /**
     * @param array<array-key, mixed> $body
     *
     * @return array<string, mixed>
     */
    private function sanitizeBody(array $body): array
    {
        $sanitized = [];

        foreach ($body as $key => $value) {
            $stringKey = (string) $key;
            $lowerKey  = strtolower($stringKey);

            if (in_array($lowerKey, self::REDACTED_KEYS, true)) {
                $sanitized[$stringKey] = '[REDACTED]';
            } elseif (is_array($value)) {
                /* @var array<array-key, mixed> $value */
                $sanitized[$stringKey] = $this->sanitizeBody($value);
            } else {
                $sanitized[$stringKey] = $value;
            }
        }

        return $sanitized;
    }

    /**
     * @param array<string, array<int, string|null>> $headers
     *
     * @return array<string, mixed>
     */
    private function sanitizeHeaders(array $headers): array
    {
        $sanitized = [];

        foreach ($headers as $key => $values) {
            $lowerKey = strtolower($key);

            if (in_array($lowerKey, self::EXCLUDED_HEADERS, true)) {
                $sanitized[$key] = '[REDACTED]';
            } else {
                $sanitized[$key] = $values;
            }
        }

        return $sanitized;
    }

    private function shouldLog(Request $request): bool
    {
        $routeName = $request->route()?->getName();

        if ($routeName === null) {
            return true;
        }

        foreach (self::EXCLUDED_ROUTES as $pattern) {
            if (fnmatch($pattern, $routeName)) {
                return false;
            }
        }

        return true;
    }
}
