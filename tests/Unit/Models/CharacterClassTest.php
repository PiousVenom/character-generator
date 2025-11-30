<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\CharacterClass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class CharacterClassTest extends TestCase
{
    use RefreshDatabase;

    public function testArmorProficienciesIsCastToArray(): void
    {
        $proficiencies = ['light', 'medium', 'heavy', 'shields'];
        $class         = $this->createCharacterClass(['armor_proficiencies' => $proficiencies]);

        $this->assertIsArray($class->armor_proficiencies);
        $this->assertSame($proficiencies, $class->armor_proficiencies);
    }

    public function testCharacterClassCanBeSoftDeleted(): void
    {
        $class = $this->createCharacterClass();

        $class->delete();

        $this->assertSoftDeleted('classes', ['id' => $class->id]);
    }

    public function testCharacterClassHasUuidPrimaryKey(): void
    {
        $class = $this->createCharacterClass();

        $this->assertTrue(Str::isUuid($class->id));
    }

    public function testCharacterClassIsNotAutoIncrementing(): void
    {
        $class = new CharacterClass();

        $this->assertFalse($class->incrementing);
    }

    public function testCharacterClassKeyTypeIsString(): void
    {
        $class = new CharacterClass();

        $this->assertSame('string', $class->getKeyType());
    }

    public function testCharacterClassUsesClassesTable(): void
    {
        $class = new CharacterClass();

        $this->assertSame('classes', $class->getTable());
    }

    public function testHitDieIsCastToInteger(): void
    {
        $class = $this->createCharacterClass(['hit_die' => '10']);

        $this->assertIsInt($class->hit_die);
        $this->assertSame(10, $class->hit_die);
    }

    public function testNullableSpellcastingAbility(): void
    {
        $class = $this->createCharacterClass(['spellcasting_ability' => null]);

        $this->assertNull($class->spellcasting_ability);
    }

    public function testPrimaryAbilitiesIsCastToArray(): void
    {
        $abilities = ['strength', 'constitution'];
        $class     = $this->createCharacterClass(['primary_abilities' => $abilities]);

        $this->assertIsArray($class->primary_abilities);
        $this->assertSame($abilities, $class->primary_abilities);
    }

    public function testSavingThrowProficienciesIsCastToArray(): void
    {
        $proficiencies = ['strength', 'constitution'];
        $class         = $this->createCharacterClass(['saving_throw_proficiencies' => $proficiencies]);

        $this->assertIsArray($class->saving_throw_proficiencies);
        $this->assertSame($proficiencies, $class->saving_throw_proficiencies);
    }

    public function testSkillChoicesIsCastToArray(): void
    {
        $choices = ['count' => 2, 'options' => ['athletics', 'perception', 'survival']];
        $class   = $this->createCharacterClass(['skill_choices' => $choices]);

        $this->assertIsArray($class->skill_choices);
        $this->assertSame($choices, $class->skill_choices);
    }

    public function testSoftDeletedClassCanBeRestored(): void
    {
        $class = $this->createCharacterClass();

        $class->delete();
        $class->restore();

        $this->assertDatabaseHas('classes', [
            'id'         => $class->id,
            'deleted_at' => null,
        ]);
    }

    public function testSpellcastingAbilityCanBeSet(): void
    {
        $class = $this->createCharacterClass(['spellcasting_ability' => 'intelligence']);

        $this->assertSame('intelligence', $class->spellcasting_ability);
    }

    public function testStartingEquipmentIsCastToArray(): void
    {
        $equipment = [
            ['type' => 'choice', 'options' => ['greataxe', 'martial weapon']],
            ['type' => 'fixed', 'items' => ['handaxes x2', 'explorer pack']],
        ];
        $class = $this->createCharacterClass(['starting_equipment' => $equipment]);

        $this->assertIsArray($class->starting_equipment);
        $this->assertSame($equipment, $class->starting_equipment);
    }

    public function testSubclassLevelIsCastToInteger(): void
    {
        $class = $this->createCharacterClass(['subclass_level' => '3']);

        $this->assertIsInt($class->subclass_level);
        $this->assertSame(3, $class->subclass_level);
    }

    public function testToolProficienciesIsCastToArray(): void
    {
        $proficiencies = ["smith's tools", 'gaming set'];
        $class         = $this->createCharacterClass(['tool_proficiencies' => $proficiencies]);

        $this->assertIsArray($class->tool_proficiencies);
        $this->assertSame($proficiencies, $class->tool_proficiencies);
    }

    public function testWeaponProficienciesIsCastToArray(): void
    {
        $proficiencies = ['simple', 'martial'];
        $class         = $this->createCharacterClass(['weapon_proficiencies' => $proficiencies]);

        $this->assertIsArray($class->weapon_proficiencies);
        $this->assertSame($proficiencies, $class->weapon_proficiencies);
    }

    /**
     * @param array<string, mixed> $overrides
     */
    private function createCharacterClass(array $overrides = []): CharacterClass
    {
        $defaults = [
            'name'                       => 'Test Class',
            'slug'                       => 'test-class-'.Str::random(5),
            'description'                => 'A test class for testing purposes.',
            'hit_die'                    => 10,
            'primary_abilities'          => ['strength'],
            'saving_throw_proficiencies' => ['strength', 'constitution'],
            'armor_proficiencies'        => ['light', 'medium', 'heavy', 'shields'],
            'weapon_proficiencies'       => ['simple', 'martial'],
            'tool_proficiencies'         => null,
            'skill_choices'              => ['count' => 2, 'options' => ['athletics', 'perception']],
            'starting_equipment'         => [],
            'spellcasting_ability'       => null,
            'subclass_level'             => 3,
        ];

        return CharacterClass::create(array_merge($defaults, $overrides));
    }
}
