<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Middleware;

use App\Http\Middleware\CorrelationId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class CorrelationIdTest extends TestCase
{
    use RefreshDatabase;

    public function testCorrelationIdHeaderConstantValue(): void
    {
        $this->assertSame('X-Correlation-ID', CorrelationId::HEADER_NAME);
    }

    public function testCorrelationIdIsAvailableThroughoutRequestLifecycle(): void
    {
        $providedId = Str::uuid()->toString();

        $this->getJson('/api/v1', [
            CorrelationId::HEADER_NAME => $providedId,
        ]);

        $this->assertSame($providedId, CorrelationId::getId());
    }

    public function testCorrelationIdIsGeneratedForRequestsWithoutHeader(): void
    {
        $response = $this->getJson('/api/v1');

        $response->assertHeader(CorrelationId::HEADER_NAME);

        $correlationId = $response->headers->get(CorrelationId::HEADER_NAME);
        $this->assertNotNull($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));
    }

    public function testCorrelationIdIsPreservedFromRequestHeader(): void
    {
        $providedId = Str::uuid()->toString();

        $response = $this->getJson('/api/v1', [
            CorrelationId::HEADER_NAME => $providedId,
        ]);

        $response->assertHeader(CorrelationId::HEADER_NAME, $providedId);
    }

    public function testCorrelationIdIsUniquePerRequest(): void
    {
        $response1 = $this->getJson('/api/v1');
        $id1       = $response1->headers->get(CorrelationId::HEADER_NAME);

        $response2 = $this->getJson('/api/v1');
        $id2       = $response2->headers->get(CorrelationId::HEADER_NAME);

        $this->assertNotEquals($id1, $id2);
        $this->assertTrue(Str::isUuid($id1));
        $this->assertTrue(Str::isUuid($id2));
    }

    public function testCorrelationIdRequestKeyConstantValue(): void
    {
        $this->assertSame('correlation_id', CorrelationId::REQUEST_KEY);
    }

    public function testGetIdReturnsNullWhenNoRequestContext(): void
    {
        // In a fresh request context without the middleware having run,
        // the getId should return null
        $this->app->instance('request', new \Illuminate\Http\Request());

        $this->assertNull(CorrelationId::getId());
    }
}
