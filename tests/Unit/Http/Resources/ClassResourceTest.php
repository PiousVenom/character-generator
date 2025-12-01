<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\ClassResource;
use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Unit tests for ClassResource transformation.
 */
final class ClassResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testArmorProficienciesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'armor_proficiencies' => ['light', 'medium', 'heavy', 'shields'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('armorProficiencies', $resource);
        $this->assertSame(['light', 'medium', 'heavy', 'shields'], $resource['armorProficiencies']);
    }

    public function testDescriptionIncluded(): void
    {
        $class = CharacterClass::factory()->create([
            'description' => 'A holy warrior',
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('description', $resource);
        $this->assertSame('A holy warrior', $resource['description']);
    }

    // =====================================
    // snake_case to camelCase Tests
    // =====================================

    public function testHitDieTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'hit_die' => 10,
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('hitDie', $resource);
        $this->assertSame(10, $resource['hitDie']);
        $this->assertArrayNotHasKey('hit_die', $resource);
    }

    // =====================================
    // Core Fields Tests
    // =====================================

    public function testIdIncluded(): void
    {
        $class = CharacterClass::factory()->create();

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('id', $resource);
        $this->assertSame($class->id, $resource['id']);
    }

    public function testNameIncluded(): void
    {
        $class = CharacterClass::factory()->create(['name' => 'Paladin']);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('name', $resource);
        $this->assertSame('Paladin', $resource['name']);
    }

    // =====================================
    // JSON Columns Properly Exposed Tests
    // =====================================

    public function testPrimaryAbilitiesIsArray(): void
    {
        $class = CharacterClass::factory()->create([
            'primary_abilities' => ['intelligence'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertIsArray($resource['primaryAbilities']);
        $this->assertContains('intelligence', $resource['primaryAbilities']);
    }

    public function testPrimaryAbilitiesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'primary_abilities' => ['strength', 'constitution'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('primaryAbilities', $resource);
        $this->assertSame(['strength', 'constitution'], $resource['primaryAbilities']);
    }

    // =====================================
    // Complete Resource Structure Test
    // =====================================

    public function testResourceContainsAllExpectedKeys(): void
    {
        $class = CharacterClass::factory()->create();

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $expectedKeys = [
            'id',
            'name',
            'slug',
            'description',
            'hitDie',
            'primaryAbilities',
            'savingThrowProficiencies',
            'armorProficiencies',
            'weaponProficiencies',
            'toolProficiencies',
            'skillChoices',
            'startingEquipment',
            'spellcastingAbility',
            'subclassLevel',
            'subclasses',
            'features',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resource, "Resource should contain key: {$key}");
        }
    }

    public function testSavingThrowProficienciesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'saving_throw_proficiencies' => ['strength', 'constitution'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('savingThrowProficiencies', $resource);
        $this->assertSame(['strength', 'constitution'], $resource['savingThrowProficiencies']);
    }

    public function testSkillChoicesIsArray(): void
    {
        $class = CharacterClass::factory()->create([
            'skill_choices' => [
                'choose'  => 3,
                'options' => ['arcana', 'history', 'investigation', 'medicine', 'religion'],
            ],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertIsArray($resource['skillChoices']);
        $this->assertArrayHasKey('choose', $resource['skillChoices']);
        $this->assertArrayHasKey('options', $resource['skillChoices']);
    }

    public function testSkillChoicesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'skill_choices' => [
                'choose'  => 2,
                'options' => ['athletics', 'acrobatics', 'perception'],
            ],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('skillChoices', $resource);
        $this->assertIsArray($resource['skillChoices']);
    }

    public function testSlugIncluded(): void
    {
        $class = CharacterClass::factory()->create(['slug' => 'paladin']);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('slug', $resource);
        $this->assertSame('paladin', $resource['slug']);
    }

    public function testSpellcastingAbilityTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'spellcasting_ability' => 'wisdom',
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('spellcastingAbility', $resource);
        $this->assertSame('wisdom', $resource['spellcastingAbility']);
    }

    public function testStartingEquipmentIsArray(): void
    {
        $class = CharacterClass::factory()->create([
            'starting_equipment' => [
                ['item' => 'Spellbook', 'quantity' => 1],
            ],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertIsArray($resource['startingEquipment']);
    }

    public function testStartingEquipmentTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'starting_equipment' => [
                ['item' => 'Longsword', 'quantity' => 1],
                ['item' => 'Shield', 'quantity' => 1],
            ],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('startingEquipment', $resource);
        $this->assertIsArray($resource['startingEquipment']);
    }

    // =====================================
    // Nested Relationships Tests
    // =====================================

    public function testSubclassesIsCollectionWhenLoaded(): void
    {
        $class = CharacterClass::factory()->create();
        Subclass::factory()->for($class, 'class')->count(2)->create();
        $class->load('subclasses');

        $classResource = new ClassResource($class);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $classResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('subclasses', $data);
        /** @var array<int, array<string, mixed>> $subclasses */
        $subclasses = $data['subclasses'];
        $this->assertIsArray($subclasses);
        $this->assertCount(2, $subclasses);
    }

    public function testSubclassLevelTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'subclass_level' => 3,
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('subclassLevel', $resource);
        $this->assertSame(3, $resource['subclassLevel']);
    }

    public function testSubclassResourceContainsExpectedFields(): void
    {
        $class = CharacterClass::factory()->create();
        Subclass::factory()->for($class, 'class')->create([
            'name'        => 'Champion',
            'description' => 'A fighter focused on critical hits',
        ]);
        $class->load('subclasses');

        $classResource = new ClassResource($class);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $classResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('subclasses', $data);
        /** @var array<int, array<string, mixed>> $subclasses */
        $subclasses = $data['subclasses'];
        $this->assertIsArray($subclasses);
        $this->assertNotEmpty($subclasses);
        $this->assertArrayHasKey('name', $subclasses[0]);
        $this->assertSame('Champion', $subclasses[0]['name']);
    }

    public function testToolProficienciesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'tool_proficiencies' => ['thieves-tools'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('toolProficiencies', $resource);
        $this->assertSame(['thieves-tools'], $resource['toolProficiencies']);
    }

    public function testWeaponProficienciesTransformedToCamelCase(): void
    {
        $class = CharacterClass::factory()->create([
            'weapon_proficiencies' => ['simple', 'martial'],
        ]);

        $resource = (new ClassResource($class))->toArray($this->makeRequest());

        $this->assertArrayHasKey('weaponProficiencies', $resource);
        $this->assertSame(['simple', 'martial'], $resource['weaponProficiencies']);
    }

    /**
     * Create a mock request for resource transformation.
     */
    private function makeRequest(): Request
    {
        return new Request();
    }
}
