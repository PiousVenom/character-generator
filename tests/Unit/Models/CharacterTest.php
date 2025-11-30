<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\AbilityScore;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class CharacterTest extends TestCase
{
    use RefreshDatabase;

    public function testAppearanceIsCastToArray(): void
    {
        $appearance = [
            'height' => '6 feet',
            'weight' => '180 lbs',
            'eyes'   => 'blue',
            'hair'   => 'brown',
        ];
        $character = $this->createCharacter(['appearance' => $appearance]);

        $this->assertIsArray($character->appearance);
        $this->assertSame($appearance, $character->appearance);
    }

    public function testArmorClassIsCastToInteger(): void
    {
        $character = $this->createCharacter(['armor_class' => '16']);

        $this->assertIsInt($character->armor_class);
        $this->assertSame(16, $character->armor_class);
    }

    public function testCharacterBelongsToBackground(): void
    {
        $background = Background::create([
            'name'                => 'Soldier',
            'slug'                => 'soldier',
            'description'         => 'Military background.',
            'skill_proficiencies' => ['athletics', 'intimidation'],
            'tool_proficiency'    => 'gaming set',
            'starting_equipment'  => [],
            'feature_name'        => 'Military Rank',
            'feature_description' => 'You have a military rank.',
        ]);

        $character = $this->createCharacter(['background_id' => $background->id]);

        $this->assertNotNull($character->background);
        $this->assertTrue($character->background->is($background));
    }

    public function testCharacterBelongsToClass(): void
    {
        $class = CharacterClass::create([
            'name'                       => 'Fighter',
            'slug'                       => 'fighter',
            'description'                => 'A warrior class.',
            'hit_die'                    => 10,
            'primary_abilities'          => ['strength'],
            'saving_throw_proficiencies' => ['strength', 'constitution'],
            'armor_proficiencies'        => ['all'],
            'weapon_proficiencies'       => ['all'],
            'skill_choices'              => ['count' => 2, 'options' => ['athletics']],
            'starting_equipment'         => [],
            'subclass_level'             => 3,
        ]);

        $character = $this->createCharacter(['class_id' => $class->id]);

        $this->assertNotNull($character->class);
        $this->assertTrue($character->class->is($class));
    }

    public function testCharacterBelongsToSpecies(): void
    {
        $species = Species::create([
            'name'                  => 'Human',
            'slug'                  => 'human',
            'description'           => 'The most common race.',
            'size'                  => 'medium',
            'speed'                 => 30,
            'traits'                => [],
            'ability_score_bonuses' => ['+1 to all'],
            'languages'             => ['common'],
        ]);

        $character = $this->createCharacter(['species_id' => $species->id]);

        $this->assertNotNull($character->species);
        $this->assertTrue($character->species->is($species));
    }

    public function testCharacterCanBeCreatedWithoutBackground(): void
    {
        $character = Character::create([
            'name'          => 'Test',
            'background_id' => null,
        ]);

        $this->assertNull($character->background_id);
        $this->assertNull($character->background);
    }

    public function testCharacterCanBeCreatedWithoutClass(): void
    {
        $character = Character::create([
            'name'     => 'Test',
            'class_id' => null,
        ]);

        $this->assertNull($character->class_id);
        $this->assertNull($character->class);
    }

    public function testCharacterCanBeCreatedWithoutSpecies(): void
    {
        $character = Character::create([
            'name'       => 'Test',
            'species_id' => null,
        ]);

        $this->assertNull($character->species_id);
        $this->assertNull($character->species);
    }

    public function testCharacterCanBeSoftDeleted(): void
    {
        $character = $this->createCharacter();

        $character->delete();

        $this->assertSoftDeleted('characters', ['id' => $character->id]);
    }

    public function testCharacterHasOneAbilityScores(): void
    {
        $character = $this->createCharacter();

        $abilityScore = AbilityScore::create([
            'character_id' => $character->id,
            'strength'     => 16,
            'dexterity'    => 14,
            'constitution' => 15,
            'intelligence' => 10,
            'wisdom'       => 12,
            'charisma'     => 8,
        ]);

        $this->assertNotNull($character->abilityScores);
        $this->assertTrue($character->abilityScores->is($abilityScore));
    }

    public function testCharacterHasUuidPrimaryKey(): void
    {
        $character = $this->createCharacter();

        $this->assertTrue(Str::isUuid($character->id));
    }

    public function testCharacterIsNotAutoIncrementing(): void
    {
        $character = new Character();

        $this->assertFalse($character->incrementing);
    }

    public function testCharacterKeyTypeIsString(): void
    {
        $character = new Character();

        $this->assertSame('string', $character->getKeyType());
    }

    public function testCurrentHitPointsIsCastToInteger(): void
    {
        $character = $this->createCharacter(['current_hit_points' => '30']);

        $this->assertIsInt($character->current_hit_points);
        $this->assertSame(30, $character->current_hit_points);
    }

    public function testDefaultExperiencePointsIsZero(): void
    {
        $character = Character::create(['name' => 'Test']);

        $this->assertSame(0, $character->experience_points);
    }

    public function testDefaultInspirationIsFalse(): void
    {
        $character = Character::create(['name' => 'Test']);

        $this->assertFalse($character->inspiration);
    }

    public function testDefaultLevelIsOne(): void
    {
        $character = Character::create(['name' => 'Test']);

        $this->assertSame(1, $character->level);
    }

    public function testDefaultProficiencyBonusIsTwo(): void
    {
        $character = Character::create(['name' => 'Test']);

        $this->assertSame(2, $character->proficiency_bonus);
    }

    public function testDefaultTemporaryHitPointsIsZero(): void
    {
        $character = Character::create(['name' => 'Test']);

        $this->assertSame(0, $character->temporary_hit_points);
    }

    public function testExperiencePointsIsCastToInteger(): void
    {
        $character = $this->createCharacter(['experience_points' => '6500']);

        $this->assertIsInt($character->experience_points);
        $this->assertSame(6500, $character->experience_points);
    }

    public function testInspirationIsCastToBoolean(): void
    {
        $character = $this->createCharacter(['inspiration' => 1]);

        $this->assertIsBool($character->inspiration);
        $this->assertTrue($character->inspiration);
    }

    public function testLevelIsCastToInteger(): void
    {
        $character = $this->createCharacter(['level' => '5']);

        $this->assertIsInt($character->level);
        $this->assertSame(5, $character->level);
    }

    public function testMaxHitPointsIsCastToInteger(): void
    {
        $character = $this->createCharacter(['max_hit_points' => '45']);

        $this->assertIsInt($character->max_hit_points);
        $this->assertSame(45, $character->max_hit_points);
    }

    public function testScopeByClass(): void
    {
        $class = CharacterClass::create([
            'name'                       => 'Wizard',
            'slug'                       => 'wizard',
            'description'                => 'A spellcaster class.',
            'hit_die'                    => 6,
            'primary_abilities'          => ['intelligence'],
            'saving_throw_proficiencies' => ['intelligence', 'wisdom'],
            'armor_proficiencies'        => [],
            'weapon_proficiencies'       => ['simple'],
            'skill_choices'              => ['count' => 2, 'options' => ['arcana']],
            'starting_equipment'         => [],
            'spellcasting_ability'       => 'intelligence',
            'subclass_level'             => 2,
        ]);

        $this->createCharacter(['class_id' => $class->id]);
        $this->createCharacter(['class_id' => null]);

        $results = Character::byClass($class->id)->get();

        $this->assertCount(1, $results);
        $first = $results->first();
        $this->assertNotNull($first);
        $this->assertSame($class->id, $first->class_id);
    }

    public function testScopeByLevelMinimum(): void
    {
        $this->createCharacter(['level' => 1]);
        $this->createCharacter(['level' => 5]);
        $this->createCharacter(['level' => 10]);

        $results = Character::byLevel(5)->get();

        $this->assertCount(2, $results);
        $this->assertTrue($results->every(static fn (Character $c): bool => $c->level >= 5));
    }

    public function testScopeByLevelRange(): void
    {
        $this->createCharacter(['level' => 1]);
        $this->createCharacter(['level' => 5]);
        $this->createCharacter(['level' => 10]);

        $results = Character::byLevel(3, 7)->get();

        $this->assertCount(1, $results);
        $first = $results->first();
        $this->assertNotNull($first);
        $this->assertSame(5, $first->level);
    }

    public function testSoftDeletedCharacterCanBeRestored(): void
    {
        $character = $this->createCharacter();

        $character->delete();
        $character->restore();

        $this->assertDatabaseHas('characters', [
            'id'         => $character->id,
            'deleted_at' => null,
        ]);
    }

    public function testSpeedIsCastToInteger(): void
    {
        $character = $this->createCharacter(['speed' => '30']);

        $this->assertIsInt($character->speed);
        $this->assertSame(30, $character->speed);
    }

    /**
     * @param array<string, mixed> $overrides
     */
    private function createCharacter(array $overrides = []): Character
    {
        $defaults = [
            'name' => 'Test Character '.Str::random(5),
        ];

        return Character::create(array_merge($defaults, $overrides));
    }
}
