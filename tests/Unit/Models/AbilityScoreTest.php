<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\AbilityScore;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

final class AbilityScoreTest extends TestCase
{
    use RefreshDatabase;

    /** @phpstan-ignore property.uninitialized (initialized in setUp) */
    private Character $character;

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function charismaModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function constitutionModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function dexterityModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function intelligenceModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function strengthModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    public function testAbilityScoreBelongsToCharacter(): void
    {
        $abilityScore = $this->createAbilityScore();

        $this->assertTrue($abilityScore->character->is($this->character));
    }

    public function testAbilityScoreCanBeSoftDeleted(): void
    {
        $abilityScore = $this->createAbilityScore();

        $abilityScore->delete();

        $this->assertSoftDeleted('ability_scores', ['id' => $abilityScore->id]);
    }

    public function testAbilityScoreHasUuidPrimaryKey(): void
    {
        $abilityScore = $this->createAbilityScore();

        $this->assertTrue(Str::isUuid($abilityScore->id));
    }

    public function testAbilityScoresAreCastToIntegers(): void
    {
        $abilityScore = $this->createAbilityScore([
            'strength'  => '15',
            'dexterity' => '14',
        ]);

        $this->assertIsInt($abilityScore->strength);
        $this->assertIsInt($abilityScore->dexterity);
        $this->assertSame(15, $abilityScore->strength);
        $this->assertSame(14, $abilityScore->dexterity);
    }

    #[DataProvider('charismaModifierProvider')]
    public function testCharismaModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['charisma' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->charisma_modifier);
    }

    #[DataProvider('constitutionModifierProvider')]
    public function testConstitutionModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['constitution' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->constitution_modifier);
    }

    #[DataProvider('dexterityModifierProvider')]
    public function testDexterityModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['dexterity' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->dexterity_modifier);
    }

    public function testGetModifierMethod(): void
    {
        $abilityScore = $this->createAbilityScore([
            'strength'     => 16,
            'dexterity'    => 14,
            'constitution' => 12,
            'intelligence' => 10,
            'wisdom'       => 8,
            'charisma'     => 6,
        ]);

        $this->assertSame(3, $abilityScore->getModifier('strength'));
        $this->assertSame(2, $abilityScore->getModifier('dexterity'));
        $this->assertSame(1, $abilityScore->getModifier('constitution'));
        $this->assertSame(0, $abilityScore->getModifier('intelligence'));
        $this->assertSame(-1, $abilityScore->getModifier('wisdom'));
        $this->assertSame(-2, $abilityScore->getModifier('charisma'));
    }

    public function testGetModifierReturnsZeroForUnknownAbility(): void
    {
        $abilityScore = $this->createAbilityScore();

        $this->assertSame(0, $abilityScore->getModifier('unknown'));
    }

    #[DataProvider('intelligenceModifierProvider')]
    public function testIntelligenceModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['intelligence' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->intelligence_modifier);
    }

    public function testSoftDeletedAbilityScoreCanBeRestored(): void
    {
        $abilityScore = $this->createAbilityScore();

        $abilityScore->delete();
        $abilityScore->restore();

        $this->assertDatabaseHas('ability_scores', [
            'id'         => $abilityScore->id,
            'deleted_at' => null,
        ]);
    }

    #[DataProvider('strengthModifierProvider')]
    public function testStrengthModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['strength' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->strength_modifier);
    }

    #[DataProvider('wisdomModifierProvider')]
    public function testWisdomModifierCalculation(int $score, int $expectedModifier): void
    {
        $abilityScore = $this->createAbilityScore(['wisdom' => $score]);

        $this->assertSame($expectedModifier, $abilityScore->wisdom_modifier);
    }

    /**
     * @return array<string, array{0: int, 1: int}>
     */
    public static function wisdomModifierProvider(): array
    {
        return self::modifierTestCases();
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Create a character directly without factory
        $this->character = Character::create([
            'name'  => 'Test Character',
            'level' => 1,
        ]);
    }

    /**
     * @param array<string, mixed> $overrides
     */
    private function createAbilityScore(array $overrides = []): AbilityScore
    {
        $defaults = [
            'character_id' => $this->character->id,
            'strength'     => 10,
            'dexterity'    => 10,
            'constitution' => 10,
            'intelligence' => 10,
            'wisdom'       => 10,
            'charisma'     => 10,
        ];

        return AbilityScore::create(array_merge($defaults, $overrides));
    }

    /**
     * Standard D&D 5e modifier calculation test cases.
     *
     * @return array<string, array{0: int, 1: int}>
     */
    private static function modifierTestCases(): array
    {
        return [
            'score 1 gives -5'     => [1, -5],
            'score 2-3 gives -4'   => [3, -4],
            'score 4-5 gives -3'   => [5, -3],
            'score 6-7 gives -2'   => [7, -2],
            'score 8-9 gives -1'   => [8, -1],
            'score 10-11 gives 0'  => [10, 0],
            'score 11 gives 0'     => [11, 0],
            'score 12-13 gives +1' => [12, 1],
            'score 14-15 gives +2' => [14, 2],
            'score 16-17 gives +3' => [16, 3],
            'score 18-19 gives +4' => [18, 4],
            'score 20 gives +5'    => [20, 5],
        ];
    }
}
