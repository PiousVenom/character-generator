<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\CharacterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class CorrelationIdTest extends TestCase
{
    use RefreshDatabase;

    public function test_correlation_id_is_generated_when_not_provided(): void
    {
        CharacterClass::factory()->create();

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();

        $correlationId = $response->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));
    }

    public function test_correlation_id_is_echoed_when_provided_in_request(): void
    {
        CharacterClass::factory()->create();

        $providedId = Str::uuid()->toString();

        $response = $this->getJson('/api/v1/classes', [
            'X-Correlation-ID' => $providedId,
        ]);

        $response->assertOk();

        $this->assertEquals($providedId, $response->headers->get('X-Correlation-ID'));
    }

    public function test_correlation_id_is_regenerated_when_invalid_uuid_provided(): void
    {
        CharacterClass::factory()->create();

        $response = $this->getJson('/api/v1/classes', [
            'X-Correlation-ID' => 'invalid-uuid',
        ]);

        $response->assertOk();

        $correlationId = $response->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));
        $this->assertNotEquals('invalid-uuid', $correlationId);
    }

    public function test_correlation_id_is_in_response_headers_for_all_endpoints(): void
    {
        CharacterClass::factory()->create();

        $endpoints = [
            '/api/v1/classes',
            '/api/v1/species',
            '/api/v1/spells',
            '/api/v1/characters',
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->getJson($endpoint);

            $response->assertOk();

            $correlationId = $response->headers->get('X-Correlation-ID');

            $this->assertNotEmpty($correlationId, "Correlation ID missing for endpoint: {$endpoint}");
            $this->assertTrue(Str::isUuid($correlationId), "Invalid UUID for endpoint: {$endpoint}");
        }
    }

    public function test_correlation_id_is_in_error_responses(): void
    {
        $nonExistentId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/classes/{$nonExistentId}");

        $response->assertNotFound();

        $correlationId = $response->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));

        $response->assertJsonStructure([
            'meta' => [
                'correlationId',
            ],
        ]);

        $this->assertEquals(
            $correlationId,
            $response->json('meta.correlationId'),
        );
    }

    public function test_correlation_id_is_consistent_throughout_request_lifecycle(): void
    {
        $providedId = Str::uuid()->toString();
        $class = CharacterClass::factory()->create();

        $response = $this->getJson("/api/v1/classes/{$class->id}", [
            'X-Correlation-ID' => $providedId,
        ]);

        $response->assertOk();

        $headerCorrelationId = $response->headers->get('X-Correlation-ID');

        $this->assertEquals($providedId, $headerCorrelationId);
    }

    public function test_each_request_gets_unique_correlation_id(): void
    {
        CharacterClass::factory()->create();

        $response1 = $this->getJson('/api/v1/classes');
        $response2 = $this->getJson('/api/v1/classes');

        $response1->assertOk();
        $response2->assertOk();

        $id1 = $response1->headers->get('X-Correlation-ID');
        $id2 = $response2->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($id1);
        $this->assertNotEmpty($id2);
        $this->assertNotEquals($id1, $id2);
    }

    public function test_correlation_id_present_in_validation_errors(): void
    {
        $response = $this->postJson('/api/v1/characters', [
            'name' => '',
        ]);

        $response->assertUnprocessable();

        $correlationId = $response->headers->get('X-Correlation-ID');

        $this->assertNotEmpty($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));

        $response->assertJsonStructure([
            'meta' => [
                'correlationId',
            ],
        ]);

        $this->assertEquals(
            $correlationId,
            $response->json('meta.correlationId'),
        );
    }
}
