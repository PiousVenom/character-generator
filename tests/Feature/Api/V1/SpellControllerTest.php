<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Enums\SpellSchool;
use App\Models\Spell;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class SpellControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_spells_list(): void
    {
        Spell::factory()->count(10)->create();

        $response = $this->getJson('/api/v1/spells');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'level',
                        'school',
                        'castingTime',
                        'range',
                        'components',
                        'duration',
                        'concentration',
                        'ritual',
                    ],
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                    'pagination' => [
                        'currentPage',
                        'perPage',
                        'total',
                        'lastPage',
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Spells retrieved successfully',
                'meta' => [
                    'version' => 'v1',
                    'pagination' => [
                        'total' => 10,
                    ],
                ],
            ]);
    }

    public function test_index_respects_per_page_parameter(): void
    {
        Spell::factory()->count(20)->create();

        $response = $this->getJson('/api/v1/spells?perPage=10');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.perPage', 10)
            ->assertJsonCount(10, 'data');
    }

    public function test_index_defaults_to_50_per_page(): void
    {
        Spell::factory()->count(60)->create();

        $response = $this->getJson('/api/v1/spells');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.perPage', 50)
            ->assertJsonCount(50, 'data');
    }

    public function test_index_limits_per_page_to_100(): void
    {
        Spell::factory()->count(150)->create();

        $response = $this->getJson('/api/v1/spells?perPage=200');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.perPage', 100);
    }

    public function test_index_sorts_spells_by_level_then_name(): void
    {
        Spell::factory()->create(['name' => 'Fireball', 'level' => 3]);
        Spell::factory()->create(['name' => 'Magic Missile', 'level' => 1]);
        Spell::factory()->create(['name' => 'Shield', 'level' => 1]);
        Spell::factory()->create(['name' => 'Lightning Bolt', 'level' => 3]);

        $response = $this->getJson('/api/v1/spells');

        $response->assertOk();

        $spells = collect($response->json('data'));
        $names = $spells->pluck('name')->all();

        $this->assertEquals([
            'Magic Missile',
            'Shield',
            'Fireball',
            'Lightning Bolt',
        ], $names);
    }

    public function test_show_returns_single_spell(): void
    {
        $spell = Spell::factory()->create([
            'name' => 'Fireball',
            'level' => 3,
            'school' => SpellSchool::Evocation->value,
            'casting_time' => '1 action',
            'range' => '150 feet',
            'components' => ['V', 'S', 'M'],
            'duration' => 'Instantaneous',
            'concentration' => false,
            'ritual' => false,
        ]);

        $response = $this->getJson("/api/v1/spells/{$spell->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'level',
                    'school',
                    'castingTime',
                    'range',
                    'components',
                    'duration',
                    'concentration',
                    'ritual',
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Spell retrieved successfully',
                'data' => [
                    'id' => $spell->id,
                    'name' => 'Fireball',
                    'level' => 3,
                    'school' => SpellSchool::Evocation->value,
                    'castingTime' => '1 action',
                    'range' => '150 feet',
                    'components' => ['V', 'S', 'M'],
                    'duration' => 'Instantaneous',
                    'concentration' => false,
                    'ritual' => false,
                ],
            ]);
    }

    public function test_show_returns_404_for_non_existent_spell(): void
    {
        $nonExistentId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/spells/{$nonExistentId}");

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
        $spell = Spell::factory()->create([
            'casting_time' => '1 action',
        ]);

        $response = $this->getJson("/api/v1/spells/{$spell->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'castingTime',
                ],
            ]);

        $data = $response->json('data');
        $this->assertArrayNotHasKey('casting_time', $data);
        $this->assertArrayHasKey('castingTime', $data);
    }

    public function test_response_includes_correlation_id(): void
    {
        $spell = Spell::factory()->create();

        $response = $this->getJson("/api/v1/spells/{$spell->id}");

        $response->assertOk();

        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
        $this->assertTrue(Str::isUuid($response->headers->get('X-Correlation-ID')));
    }

    public function test_response_echoes_provided_correlation_id(): void
    {
        $spell = Spell::factory()->create();
        $correlationId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/spells/{$spell->id}", [
            'X-Correlation-ID' => $correlationId,
        ]);

        $response->assertOk();

        $this->assertEquals($correlationId, $response->headers->get('X-Correlation-ID'));
    }

    public function test_index_returns_empty_array_when_no_spells_exist(): void
    {
        $response = $this->getJson('/api/v1/spells');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [],
                'message' => 'Spells retrieved successfully',
            ])
            ->assertJsonPath('meta.pagination.total', 0);
    }
}
