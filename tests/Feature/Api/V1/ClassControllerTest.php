<?php

declare(strict_types=1);

namespace Tests\Feature\Api\V1;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Feature tests for Class API endpoints (read-only).
 */
final class ClassControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexClassesOrderedByName(): void
    {
        CharacterClass::factory()->create(['name' => 'Wizard']);
        CharacterClass::factory()->create(['name' => 'Barbarian']);
        CharacterClass::factory()->create(['name' => 'Fighter']);

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();
        $data = $response->json('data');
        $this->assertIsArray($data);
        $names = collect($data)->pluck('name')->toArray();
        $this->assertSame(['Barbarian', 'Fighter', 'Wizard'], $names);
    }

    public function testIndexIncludesCorrelationIdHeader(): void
    {
        $response = $this->getJson('/api/v1/classes');

        $response->assertHeader('X-Correlation-ID');
    }

    public function testIndexReturnsAllClasses(): void
    {
        CharacterClass::factory()->count(5)->create();

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();
        $response->assertJsonCount(5, 'data');
    }

    public function testIndexReturnsCamelCaseFields(): void
    {
        CharacterClass::factory()->create([
            'hit_die'                    => 10,
            'primary_abilities'          => ['strength'],
            'saving_throw_proficiencies' => ['strength', 'constitution'],
            'spellcasting_ability'       => null,
        ]);

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();
        $data = $response->json('data.0');
        $this->assertIsArray($data);
        $this->assertArrayHasKey('hitDie', $data);
        $this->assertArrayHasKey('primaryAbilities', $data);
        $this->assertArrayHasKey('savingThrowProficiencies', $data);
    }

    public function testIndexReturnsCorrectStructure(): void
    {
        CharacterClass::factory()->create([
            'name'    => 'Fighter',
            'slug'    => 'fighter',
            'hit_die' => 10,
        ]);

        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'slug',
                    'hitDie',
                ],
            ],
            'message',
            'meta',
        ]);
    }

    // =====================================
    // GET /api/v1/classes
    // =====================================

    public function testIndexReturnsEmptyArrayWhenNoClasses(): void
    {
        $response = $this->getJson('/api/v1/classes');

        $response->assertOk();
        $response->assertJson([
            'success' => true,
            'data'    => [],
        ]);
    }

    public function testShowIncludesSubclasses(): void
    {
        $class = CharacterClass::factory()->create();
        Subclass::factory()->for($class, 'class')->count(2)->create();

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'subclasses',
            ],
        ]);
        $subclasses = $response->json('data.subclasses');
        $this->assertIsArray($subclasses);
        $this->assertCount(2, $subclasses);
    }

    public function testShowReturns404ForInvalidUuidFormat(): void
    {
        $response = $this->getJson('/api/v1/classes/not-a-uuid');

        $response->assertNotFound();
    }

    public function testShowReturns404ForNonExistentClass(): void
    {
        $fakeUuid = Str::uuid()->toString();

        $response = $this->getJson("/api/v1/classes/{$fakeUuid}");

        $response->assertNotFound();
    }

    public function testShowReturnsCamelCaseFields(): void
    {
        $class = CharacterClass::factory()->create([
            'primary_abilities'          => ['intelligence'],
            'saving_throw_proficiencies' => ['intelligence', 'wisdom'],
            'armor_proficiencies'        => ['light'],
            'weapon_proficiencies'       => ['simple'],
            'spellcasting_ability'       => 'intelligence',
            'subclass_level'             => 2,
        ]);

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk();
        $response->assertJsonPath('data.primaryAbilities', ['intelligence']);
        $response->assertJsonPath('data.savingThrowProficiencies', ['intelligence', 'wisdom']);
        $response->assertJsonPath('data.armorProficiencies', ['light']);
        $response->assertJsonPath('data.weaponProficiencies', ['simple']);
        $response->assertJsonPath('data.spellcastingAbility', 'intelligence');
        $response->assertJsonPath('data.subclassLevel', 2);
    }

    // =====================================
    // GET /api/v1/classes/{uuid}
    // =====================================

    public function testShowReturnsClass(): void
    {
        $class = CharacterClass::factory()->create([
            'name'    => 'Paladin',
            'hit_die' => 10,
        ]);

        $response = $this->getJson("/api/v1/classes/{$class->id}");

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.id', $class->id);
        $response->assertJsonPath('data.name', 'Paladin');
        $response->assertJsonPath('data.hitDie', 10);
    }
}
