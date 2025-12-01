<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Feature tests for Species API endpoints (read-only).
 */
final class SpeciesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexIncludesCorrelationIdHeader(): void
    {
        $response = $this->getJson('/api/v1/species');

        $response->assertHeader('X-Correlation-ID');
    }

    public function testIndexReturnsAllSpecies(): void
    {
        Species::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/species');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    public function testIndexReturnsCamelCaseFields(): void
    {
        Species::factory()->create([
            'creature_type'      => 'Humanoid',
            'darkvision'         => 60,
            'has_lineage_choice' => true,
        ]);

        $response = $this->getJson('/api/v1/species');

        $response->assertOk();
        $data = $response->json('data.0');
        $this->assertIsArray($data);
        $this->assertArrayHasKey('creatureType', $data);
        $this->assertArrayHasKey('darkvision', $data);
        $this->assertArrayHasKey('hasLineageChoice', $data);
    }

    public function testIndexReturnsCorrectStructure(): void
    {
        Species::factory()->create([
            'name'  => 'Human',
            'slug'  => 'human',
            'size'  => 'Medium',
            'speed' => 30,
        ]);

        $response = $this->getJson('/api/v1/species');

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'size',
                    'speed',
                ],
            ],
            'message',
            'meta',
        ]);
    }

    // =====================================
    // GET /api/v1/species
    // =====================================

    public function testIndexReturnsEmptyArrayWhenNoSpecies(): void
    {
        $response = $this->getJson('/api/v1/species');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data'    => [],
        ]);
    }

    public function testShowIncludesLanguages(): void
    {
        $species = Species::factory()->create([
            'languages' => ['Common', 'Elvish'],
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk();
        $this->assertSame(['Common', 'Elvish'], $response->json('data.languages'));
    }

    public function testShowIncludesTraits(): void
    {
        $species = Species::factory()->create([
            'traits' => [
                ['name' => 'Fey Ancestry', 'description' => 'Advantage on saves vs. charmed'],
                ['name' => 'Trance', 'description' => '4 hours of trance replaces sleep'],
            ],
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk();
        $traits = $response->json('data.traits');
        $this->assertIsArray($traits);
        $this->assertCount(2, $traits);
    }

    public function testShowReturns404ForInvalidUuidFormat(): void
    {
        $response = $this->getJson('/api/v1/species/not-a-uuid');

        $response->assertNotFound();
    }

    public function testShowReturns404ForNonExistentSpecies(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/species/{$fakeUuid}");

        $response->assertNotFound();
    }

    public function testShowReturnsCamelCaseFields(): void
    {
        $species = Species::factory()->create([
            'creature_type'      => 'Humanoid',
            'has_lineage_choice' => true,
            'lineages'           => [
                ['name' => 'High Elf', 'description' => 'One Wizard cantrip'],
            ],
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk();
        $response->assertJsonPath('data.creatureType', 'Humanoid');
        $response->assertJsonPath('data.hasLineageChoice', true);
    }

    // =====================================
    // GET /api/v1/species/{uuid}
    // =====================================

    public function testShowReturnsSpecies(): void
    {
        $species = Species::factory()->create([
            'name'       => 'Elf',
            'size'       => 'Medium',
            'speed'      => 30,
            'darkvision' => 60,
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.id', $species->id);
        $response->assertJsonPath('data.name', 'Elf');
        $response->assertJsonPath('data.size', 'Medium');
        $response->assertJsonPath('data.speed', 30);
        $response->assertJsonPath('data.darkvision', 60);
    }
}
