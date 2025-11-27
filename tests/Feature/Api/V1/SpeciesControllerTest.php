<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class SpeciesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_all_species(): void
    {
        Species::factory()->count(10)->create();

        $response = $this->getJson('/api/v1/species');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'size',
                        'speed',
                        'abilityScoreIncreases',
                        'languages',
                        'traits',
                    ],
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Species retrieved successfully',
                'meta' => [
                    'version' => 'v1',
                ],
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_index_returns_species_sorted_by_name(): void
    {
        Species::factory()->create(['name' => 'Human']);
        Species::factory()->create(['name' => 'Elf']);
        Species::factory()->create(['name' => 'Dwarf']);

        $response = $this->getJson('/api/v1/species');

        $response->assertOk();

        $names = collect($response->json('data'))->pluck('name')->all();
        $this->assertEquals(['Dwarf', 'Elf', 'Human'], $names);
    }

    public function test_index_returns_empty_array_when_no_species_exist(): void
    {
        $response = $this->getJson('/api/v1/species');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Species retrieved successfully',
            ]);
    }

    public function test_show_returns_single_species(): void
    {
        $species = Species::factory()->create([
            'name' => 'Elf',
            'size' => 'Medium',
            'speed' => 30,
            'ability_score_increases' => ['dexterity' => 2],
            'languages' => ['Common', 'Elvish'],
            'traits' => ['Darkvision', 'Fey Ancestry'],
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'size',
                    'speed',
                    'abilityScoreIncreases',
                    'languages',
                    'traits',
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Species retrieved successfully',
                'data' => [
                    'id' => $species->id,
                    'name' => 'Elf',
                    'size' => 'Medium',
                    'speed' => 30,
                    'abilityScoreIncreases' => ['dexterity' => 2],
                    'languages' => ['Common', 'Elvish'],
                    'traits' => ['Darkvision', 'Fey Ancestry'],
                ],
            ]);
    }

    public function test_show_returns_404_for_non_existent_species(): void
    {
        $nonExistentId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/species/{$nonExistentId}");

        $response->assertNotFound()
            ->assertJsonStructure([
                'success',
                'error' => [
                    'code',
                    'message',
                ],
                'meta' => [
                    'timestamp',
                    'correlationId',
                ],
            ])
            ->assertJson([
                'success' => false,
                'error' => [
                    'code' => 'NOT_FOUND',
                    'message' => 'The requested resource was not found.',
                ],
            ]);
    }

    public function test_response_uses_camel_case_keys(): void
    {
        $species = Species::factory()->create([
            'ability_score_increases' => ['strength' => 2, 'constitution' => 1],
        ]);

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'abilityScoreIncreases',
                ],
            ]);

        $data = $response->json('data');
        $this->assertArrayNotHasKey('ability_score_increases', $data);
        $this->assertArrayHasKey('abilityScoreIncreases', $data);
    }

    public function test_response_includes_correlation_id(): void
    {
        $species = Species::factory()->create();

        $response = $this->getJson("/api/v1/species/{$species->id}");

        $response->assertOk();

        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
        $this->assertTrue(Str::isUuid($response->headers->get('X-Correlation-ID')));
    }

    public function test_response_echoes_provided_correlation_id(): void
    {
        $species = Species::factory()->create();
        $correlationId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/species/{$species->id}", [
            'X-Correlation-ID' => $correlationId,
        ]);

        $response->assertOk();

        $this->assertEquals($correlationId, $response->headers->get('X-Correlation-ID'));
    }
}
