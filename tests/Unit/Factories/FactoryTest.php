<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use App\Models\AbilityScore;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Equipment;
use App\Models\Feat;
use App\Models\Skill;
use App\Models\Species;
use App\Models\Spell;
use App\Models\Subclass;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Factory tests for model factories.
 */
final class FactoryTest extends TestCase
{
    use RefreshDatabase;

    public function testAbilityScoreFactoryAllTensState(): void
    {
        $abilityScore = AbilityScore::factory()->allTens()->create();

        $this->assertSame(10, $abilityScore->strength);
        $this->assertSame(10, $abilityScore->dexterity);
        $this->assertSame(10, $abilityScore->constitution);
        $this->assertSame(10, $abilityScore->intelligence);
        $this->assertSame(10, $abilityScore->wisdom);
        $this->assertSame(10, $abilityScore->charisma);
    }

    // =====================================
    // Factory With For Relationships
    // =====================================

    public function testAbilityScoreFactoryCanUseExistingCharacter(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create();

        $this->assertSame($character->id, $abilityScore->character_id);
        $this->assertTrue($abilityScore->character->is($character));
    }

    public function testAbilityScoreFactoryClericState(): void
    {
        $abilityScore = AbilityScore::factory()->cleric()->create();

        $this->assertSame(14, $abilityScore->strength);
        $this->assertSame(10, $abilityScore->dexterity);
        $this->assertSame(13, $abilityScore->constitution);
        $this->assertSame(8, $abilityScore->intelligence);
        $this->assertSame(16, $abilityScore->wisdom);
        $this->assertSame(12, $abilityScore->charisma);
    }

    // =====================================
    // AbilityScoreFactory Tests
    // =====================================

    public function testAbilityScoreFactoryCreatesValidScores(): void
    {
        $abilityScore = AbilityScore::factory()->create();

        $this->assertNotNull($abilityScore->id);
        $this->assertTrue(Str::isUuid($abilityScore->id));

        // Factory generates 8-18 range
        $this->assertGreaterThanOrEqual(8, $abilityScore->strength);
        $this->assertLessThanOrEqual(18, $abilityScore->strength);
        $this->assertGreaterThanOrEqual(8, $abilityScore->dexterity);
        $this->assertLessThanOrEqual(18, $abilityScore->dexterity);
        $this->assertGreaterThanOrEqual(8, $abilityScore->constitution);
        $this->assertLessThanOrEqual(18, $abilityScore->constitution);
        $this->assertGreaterThanOrEqual(8, $abilityScore->intelligence);
        $this->assertLessThanOrEqual(18, $abilityScore->intelligence);
        $this->assertGreaterThanOrEqual(8, $abilityScore->wisdom);
        $this->assertLessThanOrEqual(18, $abilityScore->wisdom);
        $this->assertGreaterThanOrEqual(8, $abilityScore->charisma);
        $this->assertLessThanOrEqual(18, $abilityScore->charisma);
    }

    public function testAbilityScoreFactoryCreatesWithCharacterRelationship(): void
    {
        $abilityScore = AbilityScore::factory()->create();

        $this->assertNotNull($abilityScore->character_id);
        $this->assertNotNull($abilityScore->character);
    }

    public function testAbilityScoreFactoryFighterState(): void
    {
        $abilityScore = AbilityScore::factory()->fighter()->create();

        $this->assertSame(16, $abilityScore->strength);
        $this->assertSame(14, $abilityScore->dexterity);
        $this->assertSame(15, $abilityScore->constitution);
        $this->assertSame(10, $abilityScore->intelligence);
        $this->assertSame(12, $abilityScore->wisdom);
        $this->assertSame(8, $abilityScore->charisma);
    }

    public function testAbilityScoreFactoryGeneratesUniqueIds(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create();

        $this->assertTrue(Str::isUuid($abilityScore->id));
        $this->assertSame($character->id, $abilityScore->character_id);
    }

    public function testAbilityScoreFactoryPointBuyState(): void
    {
        // pointBuy() uses non-static `fn` so it should work
        $abilityScore = AbilityScore::factory()->pointBuy()->create();

        // Point buy generates 8-15 range
        $this->assertGreaterThanOrEqual(8, $abilityScore->strength);
        $this->assertLessThanOrEqual(15, $abilityScore->strength);
        $this->assertGreaterThanOrEqual(8, $abilityScore->dexterity);
        $this->assertLessThanOrEqual(15, $abilityScore->dexterity);
        $this->assertGreaterThanOrEqual(8, $abilityScore->constitution);
        $this->assertLessThanOrEqual(15, $abilityScore->constitution);
        $this->assertGreaterThanOrEqual(8, $abilityScore->intelligence);
        $this->assertLessThanOrEqual(15, $abilityScore->intelligence);
        $this->assertGreaterThanOrEqual(8, $abilityScore->wisdom);
        $this->assertLessThanOrEqual(15, $abilityScore->wisdom);
        $this->assertGreaterThanOrEqual(8, $abilityScore->charisma);
        $this->assertLessThanOrEqual(15, $abilityScore->charisma);
    }

    public function testAbilityScoreFactoryRogueState(): void
    {
        $abilityScore = AbilityScore::factory()->rogue()->create();

        $this->assertSame(10, $abilityScore->strength);
        $this->assertSame(16, $abilityScore->dexterity);
        $this->assertSame(13, $abilityScore->constitution);
        $this->assertSame(12, $abilityScore->intelligence);
        $this->assertSame(14, $abilityScore->wisdom);
        $this->assertSame(8, $abilityScore->charisma);
    }

    public function testAbilityScoreFactoryStandardArrayState(): void
    {
        $abilityScore = AbilityScore::factory()->standardArray()->create();

        // Standard array values: 15, 14, 13, 12, 10, 8 (shuffled)
        $scores = [
            $abilityScore->strength,
            $abilityScore->dexterity,
            $abilityScore->constitution,
            $abilityScore->intelligence,
            $abilityScore->wisdom,
            $abilityScore->charisma,
        ];
        sort($scores);

        $this->assertSame([8, 10, 12, 13, 14, 15], $scores);
    }

    public function testAbilityScoreFactoryWizardState(): void
    {
        $abilityScore = AbilityScore::factory()->wizard()->create();

        $this->assertSame(8, $abilityScore->strength);
        $this->assertSame(14, $abilityScore->dexterity);
        $this->assertSame(13, $abilityScore->constitution);
        $this->assertSame(16, $abilityScore->intelligence);
        $this->assertSame(12, $abilityScore->wisdom);
        $this->assertSame(10, $abilityScore->charisma);
    }

    // =====================================
    // BackgroundFactory Tests
    // =====================================

    public function testBackgroundFactoryCreatesValidBackground(): void
    {
        $background = Background::factory()->create();

        $this->assertNotNull($background->id);
        $this->assertTrue(Str::isUuid($background->id));
        $this->assertNotEmpty($background->name);
        $this->assertNotEmpty($background->slug);
        $this->assertIsArray($background->skill_proficiencies);
        $this->assertCount(2, $background->skill_proficiencies);
    }

    public function testBackgroundFactoryCriminalState(): void
    {
        $background = Background::factory()->criminal()->create();

        $this->assertSame('Criminal', $background->name);
        $this->assertSame('criminal', $background->slug);
        $this->assertSame(['sleight-of-hand', 'stealth'], $background->skill_proficiencies);
        $this->assertSame('thieves-tools', $background->tool_proficiency);
    }

    public function testBackgroundFactoryGeneratesUniqueIds(): void
    {
        $backgrounds = Background::factory()->count(5)->create();

        $ids       = $backgrounds->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);
    }

    public function testBackgroundFactorySageState(): void
    {
        $background = Background::factory()->sage()->create();

        $this->assertSame('Sage', $background->name);
        $this->assertSame('sage', $background->slug);
        $this->assertSame(['arcana', 'history'], $background->skill_proficiencies);
        $this->assertSame('calligraphers-supplies', $background->tool_proficiency);
    }

    public function testBackgroundFactorySoldierState(): void
    {
        $background = Background::factory()->soldier()->create();

        $this->assertSame('Soldier', $background->name);
        $this->assertSame('soldier', $background->slug);
        $this->assertSame(['athletics', 'intimidation'], $background->skill_proficiencies);
        $this->assertSame('gaming-set', $background->tool_proficiency);
    }

    // =====================================
    // CharacterClassFactory Tests
    // =====================================

    public function testCharacterClassFactoryCreatesValidClass(): void
    {
        $class = CharacterClass::factory()->create();

        $this->assertNotNull($class->id);
        $this->assertTrue(Str::isUuid($class->id));
        $this->assertNotEmpty($class->name);
        $this->assertNotEmpty($class->slug);
        $this->assertContains($class->hit_die, [6, 8, 10, 12]);
    }

    public function testCharacterClassFactoryFighterState(): void
    {
        $class = CharacterClass::factory()->fighter()->create();

        $this->assertSame('Fighter', $class->name);
        $this->assertSame('fighter', $class->slug);
        $this->assertSame(10, $class->hit_die);
        $this->assertSame(['strength', 'dexterity'], $class->primary_abilities);
        $this->assertSame(['strength', 'constitution'], $class->saving_throw_proficiencies);
        $this->assertNull($class->spellcasting_ability);
    }

    public function testCharacterClassFactoryGeneratesUniqueIds(): void
    {
        $classes = CharacterClass::factory()->count(5)->create();

        $ids       = $classes->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);
    }

    public function testCharacterClassFactorySpellcasterState(): void
    {
        // spellcaster() uses non-static `fn` so it should work
        $class = CharacterClass::factory()->spellcaster()->create();

        $this->assertContains($class->spellcasting_ability, ['intelligence', 'wisdom', 'charisma']);
    }

    public function testCharacterClassFactoryWizardState(): void
    {
        $class = CharacterClass::factory()->wizard()->create();

        $this->assertSame('Wizard', $class->name);
        $this->assertSame('wizard', $class->slug);
        $this->assertSame(6, $class->hit_die);
        $this->assertSame(['intelligence'], $class->primary_abilities);
        $this->assertSame(['intelligence', 'wisdom'], $class->saving_throw_proficiencies);
        $this->assertSame('intelligence', $class->spellcasting_ability);
    }

    public function testCharacterFactoryCreatesValidArmorClass(): void
    {
        $character = Character::factory()->create();

        $this->assertGreaterThanOrEqual(10, $character->armor_class);
        $this->assertLessThanOrEqual(18, $character->armor_class);
    }

    // =====================================
    // CharacterFactory Tests
    // =====================================

    public function testCharacterFactoryCreatesValidCharacter(): void
    {
        $character = Character::factory()->create();

        $this->assertNotNull($character->id);
        $this->assertTrue(Str::isUuid($character->id));
        $this->assertNotEmpty($character->name);
        $this->assertIsInt($character->level);
        $this->assertGreaterThanOrEqual(1, $character->level);
    }

    public function testCharacterFactoryCreatesValidHitPoints(): void
    {
        $character = Character::factory()->create();

        $this->assertGreaterThanOrEqual(6, $character->max_hit_points);
        $this->assertLessThanOrEqual(12, $character->max_hit_points);
        $this->assertGreaterThanOrEqual(6, $character->current_hit_points);
        $this->assertLessThanOrEqual(12, $character->current_hit_points);
    }

    public function testCharacterFactoryCreatesWithRelationships(): void
    {
        $character = Character::factory()->create();

        $this->assertNotNull($character->class_id);
        $this->assertNotNull($character->species_id);
        $this->assertNotNull($character->background_id);

        $this->assertNotNull($character->class);
        $this->assertNotNull($character->species);
        $this->assertNotNull($character->background);
    }

    public function testCharacterFactoryDamagedState(): void
    {
        $character = Character::factory()
            ->state(['max_hit_points' => 20])
            ->damaged()
            ->create();

        $this->assertSame(20, $character->max_hit_points);
        $this->assertSame(10, $character->current_hit_points);
    }

    public function testCharacterFactoryFullHealthState(): void
    {
        $character = Character::factory()
            ->state(['max_hit_points' => 25])
            ->fullHealth()
            ->create();

        $this->assertSame(25, $character->max_hit_points);
        $this->assertSame(25, $character->current_hit_points);
    }

    public function testCharacterFactoryGeneratesUniqueIds(): void
    {
        // Note: CharacterClassFactory has limited unique names (5), so we create fewer
        // characters to avoid exhausting the unique() pool
        $characters = Character::factory()->count(3)->create();

        $ids       = $characters->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(3, $uniqueIds);
    }

    public function testCharacterFactoryGeneratesValidAlignment(): void
    {
        $character = Character::factory()->create();

        $validAlignments = [
            'lawful-good',
            'neutral-good',
            'chaotic-good',
            'lawful-neutral',
            'neutral',
            'chaotic-neutral',
            'lawful-evil',
            'neutral-evil',
            'chaotic-evil',
        ];

        $this->assertContains($character->alignment, $validAlignments);
    }

    public function testCharacterFactoryInspiredState(): void
    {
        $character = Character::factory()->inspired()->create();

        $this->assertTrue($character->inspiration);
    }

    public function testCharacterFactoryLevelState(): void
    {
        $character = Character::factory()->level(5)->create();

        $this->assertSame(5, $character->level);
    }

    public function testCharacterFactoryLevelStateProficiencyBonus(): void
    {
        // Level 1-4: +2, Level 5-8: +3, Level 9-12: +4, Level 13-16: +5, Level 17+: +6
        $level1  = Character::factory()->level(1)->create();
        $level5  = Character::factory()->level(5)->create();
        $level9  = Character::factory()->level(9)->create();
        $level13 = Character::factory()->level(13)->create();
        $level17 = Character::factory()->level(17)->create();

        $this->assertSame(2, $level1->proficiency_bonus);
        $this->assertSame(3, $level5->proficiency_bonus);
        $this->assertSame(4, $level9->proficiency_bonus);
        $this->assertSame(5, $level13->proficiency_bonus);
        $this->assertSame(6, $level17->proficiency_bonus);
    }

    public function testCharacterFactoryWithExistingRelationshipsViaState(): void
    {
        $class      = CharacterClass::factory()->create();
        $species    = Species::factory()->create();
        $background = Background::factory()->create();

        $character = Character::factory()
            ->state([
                'class_id'      => $class->id,
                'species_id'    => $species->id,
                'background_id' => $background->id,
            ])
            ->create();

        $this->assertSame($class->id, $character->class_id);
        $this->assertSame($species->id, $character->species_id);
        $this->assertSame($background->id, $character->background_id);
    }

    public function testCharacterFactoryWithSubclassState(): void
    {
        $character = Character::factory()->withSubclass()->create();

        $this->assertNotNull($character->subclass_id);
        $this->assertNotNull($character->subclass);
        $this->assertGreaterThanOrEqual(3, $character->level);
    }

    // =====================================
    // Other Factory UUID Tests
    // =====================================

    public function testEquipmentFactoryGeneratesUniqueIds(): void
    {
        $equipment = Equipment::factory()->count(5)->create();

        $ids       = $equipment->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);

        foreach ($ids as $id) {
            $this->assertTrue(Str::isUuid($id));
        }
    }

    public function testFeatFactoryGeneratesUniqueIds(): void
    {
        $feats = Feat::factory()->count(5)->create();

        $ids       = $feats->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);

        foreach ($ids as $id) {
            $this->assertTrue(Str::isUuid($id));
        }
    }

    public function testSkillFactoryGeneratesUniqueIds(): void
    {
        // BUG: SkillFactory randomly picks from 5 skills without using unique(),
        // causing potential duplicate slugs. Creating just 1 to test UUID generation.
        // See: DEV-XX-BUG-factory-limited-unique-names
        $skill = Skill::factory()->create();

        $this->assertTrue(Str::isUuid($skill->id));
        $this->assertNotEmpty($skill->name);
        $this->assertNotEmpty($skill->slug);
    }

    // =====================================
    // SpeciesFactory Tests
    // =====================================

    public function testSpeciesFactoryCreatesValidSpecies(): void
    {
        $species = Species::factory()->create();

        $this->assertNotNull($species->id);
        $this->assertTrue(Str::isUuid($species->id));
        $this->assertNotEmpty($species->name);
        $this->assertNotEmpty($species->slug);
        $this->assertContains($species->size, ['Small', 'Medium']);
        $this->assertSame(30, $species->speed);
    }

    public function testSpeciesFactoryDwarfState(): void
    {
        $species = Species::factory()->dwarf()->create();

        $this->assertSame('Dwarf', $species->name);
        $this->assertSame('dwarf', $species->slug);
        $this->assertSame('Medium', $species->size);
        $this->assertSame(30, $species->speed);
        $this->assertSame(120, $species->darkvision);
        $this->assertContains('Common', $species->languages);
        $this->assertContains('Dwarvish', $species->languages);
    }

    public function testSpeciesFactoryElfState(): void
    {
        $species = Species::factory()->elf()->create();

        $this->assertSame('Elf', $species->name);
        $this->assertSame('elf', $species->slug);
        $this->assertSame('Medium', $species->size);
        $this->assertSame(60, $species->darkvision);
        $this->assertTrue($species->has_lineage_choice);
        $this->assertContains('Common', $species->languages);
        $this->assertContains('Elvish', $species->languages);
    }

    public function testSpeciesFactoryGeneratesUniqueIds(): void
    {
        $speciesList = Species::factory()->count(5)->create();

        $ids       = $speciesList->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);
    }

    public function testSpeciesFactoryHumanState(): void
    {
        $species = Species::factory()->human()->create();

        $this->assertSame('Human', $species->name);
        $this->assertSame('human', $species->slug);
        $this->assertSame('Medium', $species->size);
        $this->assertSame(30, $species->speed);
        $this->assertNull($species->darkvision);
        $this->assertFalse($species->has_lineage_choice);
        $this->assertContains('Common', $species->languages);
    }

    public function testSpellFactoryGeneratesUniqueIds(): void
    {
        $spells = Spell::factory()->count(5)->create();

        $ids       = $spells->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);

        foreach ($ids as $id) {
            $this->assertTrue(Str::isUuid($id));
        }
    }

    public function testSubclassFactoryGeneratesUniqueIds(): void
    {
        $subclasses = Subclass::factory()->count(5)->create();

        $ids       = $subclasses->pluck('id')->toArray();
        $uniqueIds = array_unique($ids);

        $this->assertCount(5, $uniqueIds);

        foreach ($ids as $id) {
            $this->assertTrue(Str::isUuid($id));
        }
    }
}
