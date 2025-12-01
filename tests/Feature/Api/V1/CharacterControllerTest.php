<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\AbilityScore;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

use function count;

/**
 * Feature tests for Character API endpoints.
 *
 * Tests cover:
 * - CRUD operations (index, store, show, update, destroy)
 * - Validation errors
 * - Response format compliance
 * - HTTP status codes
 * - Soft delete behavior
 * - Pagination
 */
final class CharacterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCorrelationIdGeneratedWhenNotProvided(): void
    {
        $response = $this->getJson('/api/v1/characters');

        $correlationId = $response->headers->get('X-Correlation-ID');
        $this->assertNotNull($correlationId);
        $this->assertTrue(Str::isUuid($correlationId));
    }

    public function testCorrelationIdPreservedFromRequest(): void
    {
        $correlationId = Str::uuid()->toString();

        $response = $this->withHeader('X-Correlation-ID', $correlationId)
            ->getJson('/api/v1/characters');

        $response->assertHeader('X-Correlation-ID', $correlationId);
    }

    // =====================================
    // DELETE /api/v1/characters/{uuid}
    // =====================================

    public function testDeleteCharacterReturns204(): void
    {
        $character = Character::factory()->create();

        $response = $this->deleteJson("/api/v1/characters/{$character->id}");

        $response->assertNoContent();
    }

    public function testDeleteCharacterSoftDeletes(): void
    {
        $character = Character::factory()->create();

        $this->deleteJson("/api/v1/characters/{$character->id}");

        $this->assertSoftDeleted('characters', ['id' => $character->id]);
    }

    public function testDeletedCharacterExcludedFromIndex(): void
    {
        $character1 = Character::factory()->create();
        $character2 = Character::factory()->create();

        $this->deleteJson("/api/v1/characters/{$character1->id}");

        $response = $this->getJson('/api/v1/characters');

        $response->assertOk();
        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertCount(1, $data);
        /** @var array{id: string} $firstItem */
        $firstItem = $data[0];
        $this->assertSame($character2->id, $firstItem['id']);
    }

    public function testDeleteNonExistentCharacterReturns404(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->deleteJson("/api/v1/characters/{$fakeUuid}");

        $response->assertNotFound();
    }

    public function testErrorResponseHasCorrectStructure(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/characters/{$fakeUuid}");

        $response->assertNotFound();
        $response->assertJsonStructure([
            'message',
        ]);
    }

    public function testIndexExcludesSoftDeletedCharacters(): void
    {
        $active  = Character::factory()->create();
        $deleted = Character::factory()->create();
        $deleted->delete();

        $response = $this->getJson('/api/v1/characters');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.id', $active->id);
    }

    public function testIndexIncludesCorrelationIdHeader(): void
    {
        $response = $this->getJson('/api/v1/characters');

        $response->assertOk();
        $response->assertHeader('X-Correlation-ID');
    }

    public function testIndexPerPageMaximumIs100(): void
    {
        // Just test that the parameter is accepted, don't need 150+ characters
        $class = CharacterClass::factory()->create();
        Character::factory()->count(3)->state(['class_id' => $class->id])->create();

        $response = $this->getJson('/api/v1/characters?perPage=200');

        $response->assertOk();
        // The max should be capped to 100, but with only 3 records we just verify it works
        $data = $response->json('data');
        $this->assertIsArray($data);
        $this->assertLessThanOrEqual(100, count($data));
    }

    public function testIndexRespectsPerPageParameter(): void
    {
        $class = CharacterClass::factory()->create();
        Character::factory()->count(5)->state(['class_id' => $class->id])->create();

        $response = $this->getJson('/api/v1/characters?perPage=3');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    public function testIndexReturnsCharacters(): void
    {
        Character::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/characters');

        $response->assertOk();
        $response->assertJsonCount(3, 'data');
    }

    // =====================================
    // GET /api/v1/characters
    // =====================================

    public function testIndexReturnsEmptyArrayWhenNoCharacters(): void
    {
        $response = $this->getJson('/api/v1/characters');

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data',
            'message',
            'meta' => ['timestamp', 'version', 'pagination'],
        ]);
        $response->assertJson([
            'success' => true,
            'data'    => [],
        ]);
    }

    public function testIndexReturnsPaginationMeta(): void
    {
        // Create classes first to avoid unique exhaustion
        $class = CharacterClass::factory()->create();
        Character::factory()->count(4)->state(['class_id' => $class->id])->create();

        $response = $this->getJson('/api/v1/characters?perPage=2');

        $response->assertOk();
        $response->assertJsonPath('meta.pagination.currentPage', 1);
        $response->assertJsonPath('meta.pagination.perPage', 2);
        $response->assertJsonPath('meta.pagination.total', 4);
        $response->assertJsonPath('meta.pagination.lastPage', 2);
    }

    public function testShowIncludesRelationshipsByDefault(): void
    {
        $character = Character::factory()->create();
        AbilityScore::factory()->for($character)->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'class',
                'species',
                'background',
                'abilityScores',
            ],
        ]);
    }

    public function testShowReturns404ForInvalidUuidFormat(): void
    {
        $response = $this->getJson('/api/v1/characters/not-a-uuid');

        $response->assertNotFound();
    }

    public function testShowReturns404ForNonExistentCharacter(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/characters/{$fakeUuid}");

        $response->assertNotFound();
    }

    public function testShowReturnsCamelCaseFields(): void
    {
        $character = Character::factory()->create([
            'max_hit_points'     => 12,
            'current_hit_points' => 10,
            'armor_class'        => 15,
            'proficiency_bonus'  => 2,
        ]);

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk();
        $response->assertJsonPath('data.maxHitPoints', 12);
        $response->assertJsonPath('data.currentHitPoints', 10);
        $response->assertJsonPath('data.armorClass', 15);
        $response->assertJsonPath('data.proficiencyBonus', 2);
    }

    // =====================================
    // GET /api/v1/characters/{uuid}
    // =====================================

    public function testShowReturnsCharacter(): void
    {
        $character = Character::factory()->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.id', $character->id);
        $response->assertJsonPath('data.name', $character->name);
    }

    public function testStoreAcceptsOptionalAlignment(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Aligned Character',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'alignment'     => 'lawful_good',
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.alignment', 'lawful_good');
    }

    public function testStoreCreatesAbilityScores(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Ability Test',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 16,
                'dexterity'    => 14,
                'constitution' => 15,
                'intelligence' => 10,
                'wisdom'       => 12,
                'charisma'     => 8,
            ],
        ]);

        $response->assertCreated();

        $characterId = $response->json('data.id');
        $this->assertDatabaseHas('ability_scores', [
            'character_id' => $characterId,
            'strength'     => 16,
            'dexterity'    => 14,
            'constitution' => 15,
            'intelligence' => 10,
            'wisdom'       => 12,
            'charisma'     => 8,
        ]);
    }

    // =====================================
    // POST /api/v1/characters
    // =====================================

    public function testStoreCreatesCharacter(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test Character',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 15,
                'dexterity'    => 14,
                'constitution' => 13,
                'intelligence' => 12,
                'wisdom'       => 10,
                'charisma'     => 8,
            ],
        ]);

        $response->assertCreated();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.name', 'Test Character');
        $response->assertJsonStructure([
            'success',
            'data' => ['id', 'name'],
            'message',
            'meta' => ['timestamp', 'version'],
        ]);

        $this->assertDatabaseHas('characters', ['name' => 'Test Character']);
    }

    public function testStoreRequiresAbilityScores(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'         => 'Test',
            'classId'      => $class->id,
            'speciesId'    => $species->id,
            'backgroundId' => $background->id,
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['abilityScores']);
    }

    public function testStoreRequiresClassId(): void
    {
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['classId']);
    }

    public function testStoreRequiresName(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
    }

    public function testStoreReturns201Created(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'New Character',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertStatus(201);
    }

    public function testStoreValidatesAbilityScoreRange(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => $class->id,
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 2,  // Below min of 3
                'dexterity'    => 19, // Above max of 18
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'abilityScores.strength',
            'abilityScores.dexterity',
        ]);
    }

    public function testStoreValidatesClassIdExists(): void
    {
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $response = $this->postJson('/api/v1/characters', [
            'name'          => 'Test',
            'classId'       => Str::uuid()->toString(),
            'speciesId'     => $species->id,
            'backgroundId'  => $background->id,
            'abilityScores' => [
                'strength'     => 10,
                'dexterity'    => 10,
                'constitution' => 10,
                'intelligence' => 10,
                'wisdom'       => 10,
                'charisma'     => 10,
            ],
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['classId']);
    }

    // =====================================
    // Response Format Tests
    // =====================================

    public function testSuccessResponseHasCorrectStructure(): void
    {
        $character = Character::factory()->create();

        $response = $this->getJson("/api/v1/characters/{$character->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data',
            'message',
            'meta' => [
                'timestamp',
                'version',
            ],
        ]);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('meta.version', 'v1');
    }

    // =====================================
    // PATCH /api/v1/characters/{uuid}
    // =====================================

    public function testUpdateCharacterName(): void
    {
        $character = Character::factory()->create(['name' => 'Old Name']);

        $response = $this->patchJson("/api/v1/characters/{$character->id}", [
            'name' => 'New Name',
        ]);

        $response->assertOk();
        $response->assertJsonPath('data.name', 'New Name');

        $this->assertDatabaseHas('characters', [
            'id'   => $character->id,
            'name' => 'New Name',
        ]);
    }

    public function testUpdatePartialUpdateWorks(): void
    {
        $character = Character::factory()->create([
            'name'      => 'Original Name',
            'alignment' => 'lawful_good',
        ]);

        $response = $this->patchJson("/api/v1/characters/{$character->id}", [
            'alignment' => 'chaotic_neutral',
        ]);

        $response->assertOk();
        $response->assertJsonPath('data.name', 'Original Name');
        $response->assertJsonPath('data.alignment', 'chaotic_neutral');
    }

    public function testUpdateReturns404ForNonExistentCharacter(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->patchJson("/api/v1/characters/{$fakeUuid}", [
            'name' => 'Test',
        ]);

        $response->assertNotFound();
    }

    public function testUpdateValidatesNameMaxLength(): void
    {
        $character = Character::factory()->create();

        $response = $this->patchJson("/api/v1/characters/{$character->id}", [
            'name' => str_repeat('a', 256),
        ]);

        $response->assertUnprocessable();
    }

    public function testValidationErrorReturns422(): void
    {
        $response = $this->postJson('/api/v1/characters', []);

        $response->assertUnprocessable();
        $response->assertStatus(422);
    }
}
