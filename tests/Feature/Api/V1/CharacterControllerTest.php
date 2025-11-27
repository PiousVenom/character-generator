<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Enums\Alignment;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class CharacterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_paginated_characters_list(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        Character::factory()
            ->count(3)
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson('/api/v1/characters');

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'level',
                        'experiencePoints',
                        'alignment',
                        'maxHitPoints',
                        'currentHitPoints',
                        'temporaryHitPoints',
                        'armorClass',
                        'initiativeBonus',
                        'speed',
                        'proficiencyBonus',
                        'inspiration',
                        'classId',
                        'speciesId',
                        'backgroundId',
                        'subclassId',
                        'createdAt',
                        'updatedAt',
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
                'message' => 'Characters retrieved successfully',
                'meta' => [
                    'version' => 'v1',
                    'pagination' => [
                        'total' => 3,
                    ],
                ],
            ]);
    }

    public function test_index_respects_per_page_parameter(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        Character::factory()
            ->count(20)
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson('/api/v1/characters?perPage=5');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.perPage', 5)
            ->assertJsonCount(5, 'data');
    }

    public function test_index_limits_per_page_to_100(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        Character::factory()
            ->count(150)
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson('/api/v1/characters?perPage=200');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.perPage', 100);
    }

    public function test_store_creates_character_with_valid_data(): void
    {
        $class = CharacterClass::factory()->create(['hit_die' => 8]);
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $characterData = [
            'name' => 'Gandalf the Grey',
            'classId' => $class->id,
            'speciesId' => $species->id,
            'backgroundId' => $background->id,
            'alignment' => Alignment::NeutralGood->value,
            'abilityScores' => [
                'strength' => 10,
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 18,
                'wisdom' => 16,
                'charisma' => 13,
            ],
        ];

        $response = $this->postJson('/api/v1/characters', $characterData);

        $response->assertCreated()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'level',
                    'experiencePoints',
                    'alignment',
                    'maxHitPoints',
                    'currentHitPoints',
                    'temporaryHitPoints',
                    'armorClass',
                    'initiativeBonus',
                    'speed',
                    'proficiencyBonus',
                    'inspiration',
                    'classId',
                    'speciesId',
                    'backgroundId',
                    'subclassId',
                    'createdAt',
                    'updatedAt',
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Character created successfully',
                'data' => [
                    'name' => 'Gandalf the Grey',
                    'alignment' => Alignment::NeutralGood->value,
                    'classId' => $class->id,
                    'speciesId' => $species->id,
                    'backgroundId' => $background->id,
                    'level' => 1,
                    'experiencePoints' => 0,
                    'proficiencyBonus' => 2,
                    'inspiration' => false,
                ],
            ]);

        $this->assertDatabaseHas('characters', [
            'name' => 'Gandalf the Grey',
            'class_id' => $class->id,
            'species_id' => $species->id,
            'background_id' => $background->id,
            'alignment' => Alignment::NeutralGood->value,
        ]);

        $character = Character::where('name', 'Gandalf the Grey')->first();
        $this->assertDatabaseHas('ability_scores', [
            'character_id' => $character->id,
            'strength' => 10,
            'dexterity' => 12,
            'constitution' => 14,
            'intelligence' => 18,
            'wisdom' => 16,
            'charisma' => 13,
        ]);
    }

    public function test_store_returns_validation_error_for_missing_name(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $characterData = [
            'classId' => $class->id,
            'speciesId' => $species->id,
            'backgroundId' => $background->id,
            'alignment' => Alignment::NeutralGood->value,
            'abilityScores' => [
                'strength' => 10,
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 18,
                'wisdom' => 16,
                'charisma' => 13,
            ],
        ];

        $response = $this->postJson('/api/v1/characters', $characterData);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'success',
                'error' => [
                    'code',
                    'message',
                    'details' => [
                        'name',
                    ],
                ],
                'meta' => [
                    'timestamp',
                    'correlationId',
                ],
            ])
            ->assertJson([
                'success' => false,
                'error' => [
                    'code' => 'VALIDATION_ERROR',
                    'message' => 'The given data was invalid.',
                ],
            ]);
    }

    public function test_store_returns_validation_error_for_invalid_class_id(): void
    {
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $characterData = [
            'name' => 'Test Character',
            'classId' => Str::uuid()->toString(),
            'speciesId' => $species->id,
            'backgroundId' => $background->id,
            'alignment' => Alignment::NeutralGood->value,
            'abilityScores' => [
                'strength' => 10,
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 18,
                'wisdom' => 16,
                'charisma' => 13,
            ],
        ];

        $response = $this->postJson('/api/v1/characters', $characterData);

        $response->assertUnprocessable()
            ->assertJsonPath('error.details.classId', [
                'The selected class does not exist.',
            ]);
    }

    public function test_store_returns_validation_error_for_invalid_ability_scores(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $characterData = [
            'name' => 'Test Character',
            'classId' => $class->id,
            'speciesId' => $species->id,
            'backgroundId' => $background->id,
            'alignment' => Alignment::NeutralGood->value,
            'abilityScores' => [
                'strength' => 2, // Too low
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 18,
                'wisdom' => 16,
                'charisma' => 25, // Too high
            ],
        ];

        $response = $this->postJson('/api/v1/characters', $characterData);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'error' => [
                    'details' => [
                        'abilityScores.strength',
                        'abilityScores.charisma',
                    ],
                ],
            ]);
    }

    public function test_store_returns_validation_error_for_invalid_alignment(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $characterData = [
            'name' => 'Test Character',
            'classId' => $class->id,
            'speciesId' => $species->id,
            'backgroundId' => $background->id,
            'alignment' => 'invalid-alignment',
            'abilityScores' => [
                'strength' => 10,
                'dexterity' => 12,
                'constitution' => 14,
                'intelligence' => 18,
                'wisdom' => 16,
                'charisma' => 13,
            ],
        ];

        $response = $this->postJson('/api/v1/characters', $characterData);

        $response->assertUnprocessable()
            ->assertJsonStructure([
                'error' => [
                    'details' => [
                        'alignment',
                    ],
                ],
            ]);
    }

    public function test_show_returns_character_with_relationships(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'level',
                    'experiencePoints',
                    'alignment',
                    'maxHitPoints',
                    'currentHitPoints',
                    'temporaryHitPoints',
                    'armorClass',
                    'initiativeBonus',
                    'speed',
                    'proficiencyBonus',
                    'inspiration',
                    'classId',
                    'speciesId',
                    'backgroundId',
                    'subclassId',
                    'createdAt',
                    'updatedAt',
                ],
                'message',
                'meta' => [
                    'timestamp',
                    'version',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Character retrieved successfully',
                'data' => [
                    'id' => $character->id,
                    'name' => $character->name,
                ],
            ]);
    }

    public function test_show_returns_404_for_non_existent_character(): void
    {
        $nonExistentId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/characters/{$nonExistentId}");

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

    public function test_update_modifies_character(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create(['name' => 'Original Name']);

        $updateData = [
            'name' => 'Updated Name',
            'level' => 5,
            'experiencePoints' => 6500,
        ];

        $response = $this->putJson("/api/v1/characters/{$character->id}", $updateData);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Character updated successfully',
                'data' => [
                    'id' => $character->id,
                    'name' => 'Updated Name',
                    'level' => 5,
                    'experiencePoints' => 6500,
                ],
            ]);

        $this->assertDatabaseHas('characters', [
            'id' => $character->id,
            'name' => 'Updated Name',
            'level' => 5,
            'experience_points' => 6500,
        ]);
    }

    public function test_destroy_soft_deletes_character(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->deleteJson("/api/v1/characters/{$character->id}");

        $response->assertNoContent();

        $this->assertSoftDeleted('characters', [
            'id' => $character->id,
        ]);

        $this->assertDatabaseHas('characters', [
            'id' => $character->id,
        ]);
    }

    public function test_index_excludes_soft_deleted_characters(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        Character::factory()
            ->count(3)
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $deletedCharacter = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $deletedCharacter->delete();

        $response = $this->getJson('/api/v1/characters');

        $response->assertOk()
            ->assertJsonPath('meta.pagination.total', 3);

        $returnedIds = collect($response->json('data'))->pluck('id')->all();
        $this->assertNotContains($deletedCharacter->id, $returnedIds);
    }

    public function test_response_uses_camel_case_keys(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'maxHitPoints',
                    'currentHitPoints',
                    'temporaryHitPoints',
                    'armorClass',
                    'initiativeBonus',
                    'proficiencyBonus',
                    'classId',
                    'speciesId',
                    'backgroundId',
                    'subclassId',
                    'experiencePoints',
                    'createdAt',
                    'updatedAt',
                ],
            ]);

        $data = $response->json('data');
        $this->assertArrayNotHasKey('max_hit_points', $data);
        $this->assertArrayNotHasKey('current_hit_points', $data);
        $this->assertArrayNotHasKey('class_id', $data);
        $this->assertArrayNotHasKey('created_at', $data);
    }

    public function test_response_includes_correlation_id(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk();

        $this->assertNotEmpty($response->headers->get('X-Correlation-ID'));
        $this->assertTrue(Str::isUuid($response->headers->get('X-Correlation-ID')));
    }

    public function test_response_echoes_provided_correlation_id(): void
    {
        $class = CharacterClass::factory()->create();
        $species = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->withClass($class)
            ->withSpecies($species)
            ->withBackground($background)
            ->create();

        $correlationId = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/characters/{$character->id}", [
            'X-Correlation-ID' => $correlationId,
        ]);

        $response->assertOk();

        $this->assertEquals($correlationId, $response->headers->get('X-Correlation-ID'));
    }
}
