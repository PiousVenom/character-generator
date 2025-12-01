<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Feature tests for Health endpoint.
 */
final class HealthEndpointTest extends TestCase
{
    use RefreshDatabase;

    public function testHealthEndpointIncludesCorrelationIdHeader(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertHeader('X-Correlation-ID');
    }

    public function testHealthEndpointPreservesProvidedCorrelationId(): void
    {
        $correlationId = Str::uuid()->toString();

        $response = $this->withHeader('X-Correlation-ID', $correlationId)
            ->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertHeader('X-Correlation-ID', $correlationId);
    }

    public function testHealthEndpointReturnsCorrectStructure(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertJsonStructure([
            'status',
            'timestamp',
            'version',
        ]);
    }

    public function testHealthEndpointReturnsOk(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
    }

    public function testHealthEndpointReturnsStatusOk(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertJsonPath('status', 'ok');
    }

    public function testHealthEndpointReturnsTimestamp(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $timestamp = $response->json('timestamp');
        $this->assertIsString($timestamp);
        // Verify it's a valid ISO8601 timestamp
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
            $timestamp
        );
    }

    public function testHealthEndpointReturnsVersionV1(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertOk();
        $response->assertJsonPath('version', 'v1');
    }
}
