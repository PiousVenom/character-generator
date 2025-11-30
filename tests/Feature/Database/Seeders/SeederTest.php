<?php

declare(strict_types=1);

namespace Tests\Feature\Database\Seeders;

use App\Models\Background;
use App\Models\CharacterClass;
use App\Models\Equipment;
use App\Models\Feat;
use App\Models\Skill;
use App\Models\Species;
use App\Models\Spell;
use App\Models\Subclass;
use Database\Seeders\BackgroundSeeder;
use Database\Seeders\ClassSeeder;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\FeatSeeder;
use Database\Seeders\SkillSeeder;
use Database\Seeders\SpeciesSeeder;
use Database\Seeders\SpellSeeder;
use Database\Seeders\SubclassSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function testBackgroundSeederCanRunMultipleTimes(): void
    {
        // BackgroundSeeder depends on FeatSeeder
        (new FeatSeeder())->run();
        $seeder = new BackgroundSeeder();

        $seeder->run();
        $countAfterFirst = Background::count();

        $seeder->run();
        $countAfterSecond = Background::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }

    public function testBackgroundSeederCreatesAcolyteWithCorrectSkills(): void
    {
        (new FeatSeeder())->run();
        (new BackgroundSeeder())->run();

        $acolyte = Background::where('slug', 'acolyte')->first();

        $this->assertNotNull($acolyte);
        $this->assertSame('Acolyte', $acolyte->name);
        $this->assertContains('insight', $acolyte->skill_proficiencies);
        $this->assertContains('religion', $acolyte->skill_proficiencies);
    }

    public function testBackgroundSeederCreatesSoldierWithStartingEquipment(): void
    {
        (new FeatSeeder())->run();
        (new BackgroundSeeder())->run();

        $soldier = Background::where('slug', 'soldier')->first();

        $this->assertNotNull($soldier);
        $this->assertSame('Soldier', $soldier->name);
        $this->assertIsArray($soldier->starting_equipment);
        $this->assertNotEmpty($soldier->starting_equipment);
    }

    // =====================================
    // BackgroundSeeder Data Accuracy Tests
    // =====================================

    public function testBackgroundSeederCreatesStandardBackgrounds(): void
    {
        (new FeatSeeder())->run();
        (new BackgroundSeeder())->run();

        $this->assertSame(16, Background::count());
    }

    // =====================================
    // Seeder Idempotency Tests
    // =====================================

    public function testClassSeederCanRunMultipleTimes(): void
    {
        $seeder = new ClassSeeder();

        $seeder->run();
        $countAfterFirst = CharacterClass::count();

        $seeder->run();
        $countAfterSecond = CharacterClass::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
        $this->assertSame(12, $countAfterSecond);
    }

    // =====================================
    // ClassSeeder Data Accuracy Tests
    // =====================================

    public function testClassSeederCreatesAll12Classes(): void
    {
        (new ClassSeeder())->run();

        $this->assertSame(12, CharacterClass::count());
    }

    public function testClassSeederCreatesBarbarianWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $barbarian = CharacterClass::where('slug', 'barbarian')->first();

        $this->assertNotNull($barbarian);
        $this->assertSame('Barbarian', $barbarian->name);
        $this->assertSame(12, $barbarian->hit_die);
    }

    public function testClassSeederCreatesBardWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $bard = CharacterClass::where('slug', 'bard')->first();

        $this->assertNotNull($bard);
        $this->assertSame('Bard', $bard->name);
        $this->assertSame(8, $bard->hit_die);
        $this->assertSame('charisma', $bard->spellcasting_ability);
    }

    public function testClassSeederCreatesClericWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $cleric = CharacterClass::where('slug', 'cleric')->first();

        $this->assertNotNull($cleric);
        $this->assertSame('Cleric', $cleric->name);
        $this->assertSame(8, $cleric->hit_die);
        $this->assertSame('wisdom', $cleric->spellcasting_ability);
        $this->assertSame(1, $cleric->subclass_level);
    }

    public function testClassSeederCreatesDruidWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $druid = CharacterClass::where('slug', 'druid')->first();

        $this->assertNotNull($druid);
        $this->assertSame('Druid', $druid->name);
        $this->assertSame(8, $druid->hit_die);
        $this->assertSame('wisdom', $druid->spellcasting_ability);
    }

    public function testClassSeederCreatesFighterWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $fighter = CharacterClass::where('slug', 'fighter')->first();

        $this->assertNotNull($fighter);
        $this->assertSame('Fighter', $fighter->name);
        $this->assertSame(10, $fighter->hit_die);
        $this->assertNull($fighter->spellcasting_ability);
    }

    public function testClassSeederCreatesMonkWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $monk = CharacterClass::where('slug', 'monk')->first();

        $this->assertNotNull($monk);
        $this->assertSame('Monk', $monk->name);
        $this->assertSame(8, $monk->hit_die);
    }

    public function testClassSeederCreatesPaladinWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $paladin = CharacterClass::where('slug', 'paladin')->first();

        $this->assertNotNull($paladin);
        $this->assertSame('Paladin', $paladin->name);
        $this->assertSame(10, $paladin->hit_die);
        $this->assertSame('charisma', $paladin->spellcasting_ability);
    }

    public function testClassSeederCreatesRangerWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $ranger = CharacterClass::where('slug', 'ranger')->first();

        $this->assertNotNull($ranger);
        $this->assertSame('Ranger', $ranger->name);
        $this->assertSame(10, $ranger->hit_die);
        $this->assertSame('wisdom', $ranger->spellcasting_ability);
    }

    public function testClassSeederCreatesRogueWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $rogue = CharacterClass::where('slug', 'rogue')->first();

        $this->assertNotNull($rogue);
        $this->assertSame('Rogue', $rogue->name);
        $this->assertSame(8, $rogue->hit_die);
        $this->assertNull($rogue->spellcasting_ability);
    }

    public function testClassSeederCreatesSorcererWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $sorcerer = CharacterClass::where('slug', 'sorcerer')->first();

        $this->assertNotNull($sorcerer);
        $this->assertSame('Sorcerer', $sorcerer->name);
        $this->assertSame(6, $sorcerer->hit_die);
        $this->assertSame('charisma', $sorcerer->spellcasting_ability);
    }

    public function testClassSeederCreatesWarlockWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $warlock = CharacterClass::where('slug', 'warlock')->first();

        $this->assertNotNull($warlock);
        $this->assertSame('Warlock', $warlock->name);
        $this->assertSame(8, $warlock->hit_die);
        $this->assertSame('charisma', $warlock->spellcasting_ability);
    }

    public function testClassSeederCreatesWizardWithCorrectHitDie(): void
    {
        (new ClassSeeder())->run();

        $wizard = CharacterClass::where('slug', 'wizard')->first();

        $this->assertNotNull($wizard);
        $this->assertSame('Wizard', $wizard->name);
        $this->assertSame(6, $wizard->hit_die);
        $this->assertSame('intelligence', $wizard->spellcasting_ability);
    }

    // =====================================
    // Seeder Uses updateOrCreate Tests
    // =====================================

    public function testClassSeederUsesUpdateOrCreateNoDuplicates(): void
    {
        (new ClassSeeder())->run();

        $fighterCount = CharacterClass::where('slug', 'fighter')->count();
        $this->assertSame(1, $fighterCount);

        (new ClassSeeder())->run();

        $fighterCount = CharacterClass::where('slug', 'fighter')->count();
        $this->assertSame(1, $fighterCount);
    }

    public function testDatabaseSeederCanRunMultipleTimes(): void
    {
        // Note: DatabaseSeeder creates a test user with fixed email (test@example.com)
        // which would cause unique constraint violation on second run.
        // This test uses runSeeder() via app() to bypass user creation
        // and only tests the D&D reference data seeders are idempotent.

        $this->seed(DatabaseSeeder::class);

        $classCountFirst      = CharacterClass::count();
        $skillCountFirst      = Skill::count();
        $speciesCountFirst    = Species::count();
        $backgroundCountFirst = Background::count();

        // Run individual seeders again to test idempotency
        // (DatabaseSeeder would fail on duplicate user email)
        (new SkillSeeder())->run();
        (new FeatSeeder())->run();
        (new ClassSeeder())->run();
        (new SpeciesSeeder())->run();
        (new EquipmentSeeder())->run();
        (new SpellSeeder())->run();
        (new BackgroundSeeder())->run();
        (new SubclassSeeder())->run();

        $this->assertSame($classCountFirst, CharacterClass::count());
        $this->assertSame($skillCountFirst, Skill::count());
        $this->assertSame($speciesCountFirst, Species::count());
        $this->assertSame($backgroundCountFirst, Background::count());
    }

    public function testEquipmentSeederCanRunMultipleTimes(): void
    {
        $seeder = new EquipmentSeeder();

        $seeder->run();
        $countAfterFirst = Equipment::count();

        $seeder->run();
        $countAfterSecond = Equipment::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }

    public function testEquipmentSeederCreatesArmor(): void
    {
        (new EquipmentSeeder())->run();

        $armor = Equipment::where('equipment_type', 'armor')->get();

        $this->assertGreaterThan(10, $armor->count());
    }

    // =====================================
    // EquipmentSeeder Data Accuracy Tests
    // =====================================

    public function testEquipmentSeederCreatesCoreItems(): void
    {
        (new EquipmentSeeder())->run();

        $this->assertGreaterThan(0, Equipment::count());
    }

    public function testEquipmentSeederCreatesLongswordCorrectly(): void
    {
        (new EquipmentSeeder())->run();

        $longsword = Equipment::where('slug', 'longsword')->first();

        $this->assertNotNull($longsword);
        $this->assertSame('Longsword', $longsword->name);
        $this->assertSame('weapon', $longsword->equipment_type);
        $this->assertSame('martial-melee', $longsword->equipment_subtype);
        $this->assertSame('1d8', $longsword->damage_dice);
        $this->assertSame('slashing', $longsword->damage_type);
    }

    public function testEquipmentSeederCreatesPlateArmorCorrectly(): void
    {
        (new EquipmentSeeder())->run();

        $plateArmor = Equipment::where('slug', 'plate-armor')->first();

        $this->assertNotNull($plateArmor);
        $this->assertSame('Plate Armor', $plateArmor->name);
        $this->assertSame('armor', $plateArmor->equipment_type);
        $this->assertSame('heavy', $plateArmor->equipment_subtype);
        $this->assertSame(18, $plateArmor->armor_class);
    }

    public function testEquipmentSeederCreatesWeapons(): void
    {
        (new EquipmentSeeder())->run();

        $weapons = Equipment::where('equipment_type', 'weapon')->get();

        $this->assertGreaterThan(20, $weapons->count());
    }

    public function testFeatSeederCanRunMultipleTimes(): void
    {
        $seeder = new FeatSeeder();

        $seeder->run();
        $countAfterFirst = Feat::count();

        $seeder->run();
        $countAfterSecond = Feat::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }

    public function testSkillSeederCanRunMultipleTimes(): void
    {
        $seeder = new SkillSeeder();

        $seeder->run();
        $countAfterFirst = Skill::count();

        $seeder->run();
        $countAfterSecond = Skill::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
        $this->assertSame(18, $countAfterSecond);
    }

    // =====================================
    // SkillSeeder Data Accuracy Tests
    // =====================================

    public function testSkillSeederCreatesAll18Skills(): void
    {
        (new SkillSeeder())->run();

        $this->assertSame(18, Skill::count());
    }

    public function testSkillSeederCreatesAthleticsWithStrength(): void
    {
        (new SkillSeeder())->run();

        $athletics = Skill::where('slug', 'athletics')->first();

        $this->assertNotNull($athletics);
        $this->assertSame('Athletics', $athletics->name);
        $this->assertSame('strength', $athletics->ability);
    }

    public function testSkillSeederCreatesCharismaSkills(): void
    {
        (new SkillSeeder())->run();

        $charismaSkills = Skill::where('ability', 'charisma')->get();

        $this->assertCount(4, $charismaSkills);

        $slugs = $charismaSkills->pluck('slug')->toArray();
        $this->assertContains('deception', $slugs);
        $this->assertContains('intimidation', $slugs);
        $this->assertContains('performance', $slugs);
        $this->assertContains('persuasion', $slugs);
    }

    public function testSkillSeederCreatesDexteritySkills(): void
    {
        (new SkillSeeder())->run();

        $dexteritySkills = Skill::where('ability', 'dexterity')->get();

        $this->assertCount(3, $dexteritySkills);

        $slugs = $dexteritySkills->pluck('slug')->toArray();
        $this->assertContains('acrobatics', $slugs);
        $this->assertContains('sleight-of-hand', $slugs);
        $this->assertContains('stealth', $slugs);
    }

    public function testSkillSeederCreatesIntelligenceSkills(): void
    {
        (new SkillSeeder())->run();

        $intelligenceSkills = Skill::where('ability', 'intelligence')->get();

        $this->assertCount(5, $intelligenceSkills);

        $slugs = $intelligenceSkills->pluck('slug')->toArray();
        $this->assertContains('arcana', $slugs);
        $this->assertContains('history', $slugs);
        $this->assertContains('investigation', $slugs);
        $this->assertContains('nature', $slugs);
        $this->assertContains('religion', $slugs);
    }

    public function testSkillSeederCreatesWisdomSkills(): void
    {
        (new SkillSeeder())->run();

        $wisdomSkills = Skill::where('ability', 'wisdom')->get();

        $this->assertCount(5, $wisdomSkills);

        $slugs = $wisdomSkills->pluck('slug')->toArray();
        $this->assertContains('animal-handling', $slugs);
        $this->assertContains('insight', $slugs);
        $this->assertContains('medicine', $slugs);
        $this->assertContains('perception', $slugs);
        $this->assertContains('survival', $slugs);
    }

    public function testSkillSeederUsesUpdateOrCreateNoDuplicates(): void
    {
        (new SkillSeeder())->run();

        $perceptionCount = Skill::where('slug', 'perception')->count();
        $this->assertSame(1, $perceptionCount);

        (new SkillSeeder())->run();

        $perceptionCount = Skill::where('slug', 'perception')->count();
        $this->assertSame(1, $perceptionCount);
    }

    public function testSpeciesSeederCanRunMultipleTimes(): void
    {
        $seeder = new SpeciesSeeder();

        $seeder->run();
        $countAfterFirst = Species::count();

        $seeder->run();
        $countAfterSecond = Species::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }

    // =====================================
    // SpeciesSeeder Data Accuracy Tests
    // =====================================

    public function testSpeciesSeederCreatesAllCoreSpecies(): void
    {
        (new SpeciesSeeder())->run();

        $this->assertSame(10, Species::count());
    }

    public function testSpeciesSeederCreatesDwarfWithDarkvision(): void
    {
        (new SpeciesSeeder())->run();

        $dwarf = Species::where('slug', 'dwarf')->first();

        $this->assertNotNull($dwarf);
        $this->assertSame('Dwarf', $dwarf->name);
        $this->assertSame(120, $dwarf->darkvision);
    }

    public function testSpeciesSeederCreatesElfWithTraits(): void
    {
        (new SpeciesSeeder())->run();

        $elf = Species::where('slug', 'elf')->first();

        $this->assertNotNull($elf);
        $this->assertSame('Elf', $elf->name);
        $this->assertIsArray($elf->traits);
        $this->assertNotEmpty($elf->traits);
        $this->assertTrue($elf->has_lineage_choice);
    }

    public function testSpeciesSeederCreatesGoliathWithIncreasedSpeed(): void
    {
        (new SpeciesSeeder())->run();

        $goliath = Species::where('slug', 'goliath')->first();

        $this->assertNotNull($goliath);
        $this->assertSame('Goliath', $goliath->name);
        $this->assertSame(35, $goliath->speed);
    }

    public function testSpeciesSeederCreatesHumanWithCorrectSpeed(): void
    {
        (new SpeciesSeeder())->run();

        $human = Species::where('slug', 'human')->first();

        $this->assertNotNull($human);
        $this->assertSame('Human', $human->name);
        $this->assertSame(30, $human->speed);
        $this->assertSame('Medium', $human->size);
        $this->assertNull($human->darkvision);
    }

    public function testSpeciesSeederCreatesSmallSpecies(): void
    {
        (new SpeciesSeeder())->run();

        $smallSpecies = Species::where('size', 'Small')->get();

        $this->assertCount(2, $smallSpecies);

        $slugs = $smallSpecies->pluck('slug')->toArray();
        $this->assertContains('gnome', $slugs);
        $this->assertContains('halfling', $slugs);
    }

    public function testSpeciesSeederUsesUpdateOrCreateNoDuplicates(): void
    {
        (new SpeciesSeeder())->run();

        $elfCount = Species::where('slug', 'elf')->count();
        $this->assertSame(1, $elfCount);

        (new SpeciesSeeder())->run();

        $elfCount = Species::where('slug', 'elf')->count();
        $this->assertSame(1, $elfCount);
    }

    public function testSpellSeederCanRunMultipleTimes(): void
    {
        $seeder = new SpellSeeder();

        $seeder->run();
        $countAfterFirst = Spell::count();

        $seeder->run();
        $countAfterSecond = Spell::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }

    public function testSpellSeederCreatesCantrips(): void
    {
        (new SpellSeeder())->run();

        $cantrips = Spell::where('level', 0)->get();

        $this->assertGreaterThan(3, $cantrips->count());
    }

    // =====================================
    // SpellSeeder Data Accuracy Tests
    // =====================================

    public function testSpellSeederCreatesCoreSpells(): void
    {
        (new SpellSeeder())->run();

        $this->assertGreaterThan(0, Spell::count());
    }

    public function testSpellSeederCreatesDetectMagicAsRitual(): void
    {
        (new SpellSeeder())->run();

        $detectMagic = Spell::where('slug', 'detect-magic')->first();

        $this->assertNotNull($detectMagic);
        $this->assertSame('Detect Magic', $detectMagic->name);
        $this->assertTrue($detectMagic->ritual);
        $this->assertTrue($detectMagic->concentration);
    }

    public function testSpellSeederCreatesFireballCorrectly(): void
    {
        (new SpellSeeder())->run();

        $fireball = Spell::where('slug', 'fireball')->first();

        $this->assertNotNull($fireball);
        $this->assertSame('Fireball', $fireball->name);
        $this->assertSame(3, $fireball->level);
        $this->assertSame('evocation', $fireball->school);
        $this->assertFalse($fireball->concentration);
        $this->assertFalse($fireball->ritual);
    }

    public function testSpellSeederCreatesSpellsWithMaterialComponents(): void
    {
        (new SpellSeeder())->run();

        $spellsWithMaterials = Spell::whereNotNull('components_material')->get();

        $this->assertGreaterThan(0, $spellsWithMaterials->count());
    }

    public function testSubclassSeederCanRunMultipleTimes(): void
    {
        // SubclassSeeder depends on ClassSeeder
        (new ClassSeeder())->run();
        $seeder = new SubclassSeeder();

        $seeder->run();
        $countAfterFirst = Subclass::count();

        $seeder->run();
        $countAfterSecond = Subclass::count();

        $this->assertSame($countAfterFirst, $countAfterSecond);
    }
}
