<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

use function is_string;

final class CorrelationId
{
    public const string HEADER_NAME = 'X-Correlation-ID';

    public const string REQUEST_KEY = 'correlation_id';

    public static function getId(): ?string
    {
        $id = request()->attributes->get(self::REQUEST_KEY);

        return is_string($id) ? $id : null;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $correlationId = $request->header(self::HEADER_NAME) ?? Str::uuid()->toString();

        $request->headers->set(self::HEADER_NAME, $correlationId);
        $request->attributes->set(self::REQUEST_KEY, $correlationId);

        /** @var Response $response */
        $response = $next($request);

        $response->headers->set(self::HEADER_NAME, $correlationId);

        return $response;
    }
}
