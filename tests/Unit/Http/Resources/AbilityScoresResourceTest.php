<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\AbilityScoresResource;
use App\Models\AbilityScore;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

use function count;

/**
 * Unit tests for AbilityScoresResource transformation.
 */
final class AbilityScoresResourceTest extends TestCase
{
    use RefreshDatabase;

    // =====================================
    // All Modifiers Present Test
    // =====================================

    public function testAllSixModifiersPresent(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength'     => 15,
            'dexterity'    => 14,
            'constitution' => 13,
            'intelligence' => 12,
            'wisdom'       => 10,
            'charisma'     => 8,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $modifierKeys = [
            'strengthModifier',
            'dexterityModifier',
            'constitutionModifier',
            'intelligenceModifier',
            'wisdomModifier',
            'charismaModifier',
        ];

        foreach ($modifierKeys as $key) {
            $this->assertArrayHasKey($key, $resource, "Resource should contain key: {$key}");
            $this->assertIsInt($resource[$key], "{$key} should be an integer");
        }
    }

    public function testCharismaIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'charisma' => 8,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('charisma', $resource);
        $this->assertSame(8, $resource['charisma']);
    }

    public function testCharismaModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'charisma' => 8,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('charismaModifier', $resource);
        $this->assertSame(-1, $resource['charismaModifier']); // (8-10)/2 = -1
    }

    public function testConstitutionIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'constitution' => 15,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('constitution', $resource);
        $this->assertSame(15, $resource['constitution']);
    }

    public function testConstitutionModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'constitution' => 15,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('constitutionModifier', $resource);
        $this->assertSame(2, $resource['constitutionModifier']); // (15-10)/2 = 2.5 -> 2
    }

    public function testDexterityIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'dexterity' => 14,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('dexterity', $resource);
        $this->assertSame(14, $resource['dexterity']);
    }

    public function testDexterityModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'dexterity' => 14,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('dexterityModifier', $resource);
        $this->assertSame(2, $resource['dexterityModifier']); // (14-10)/2 = 2
    }

    public function testIntelligenceIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'intelligence' => 12,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('intelligence', $resource);
        $this->assertSame(12, $resource['intelligence']);
    }

    public function testIntelligenceModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'intelligence' => 12,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('intelligenceModifier', $resource);
        $this->assertSame(1, $resource['intelligenceModifier']); // (12-10)/2 = 1
    }

    public function testModifierForMaximumScore(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength' => 18,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        // (18-10)/2 = 4
        $this->assertSame(4, $resource['strengthModifier']);
    }

    // =====================================
    // Modifier Calculation Edge Cases
    // =====================================

    public function testModifierForMinimumScore(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength' => 3,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        // (3-10)/2 = -3.5 -> floor = -4
        $this->assertSame(-4, $resource['strengthModifier']);
    }

    public function testModifierForOddScore(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength' => 11,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        // (11-10)/2 = 0.5 -> floor = 0
        $this->assertSame(0, $resource['strengthModifier']);
    }

    // =====================================
    // Complete Resource Structure Test
    // =====================================

    public function testResourceContainsAllExpectedKeys(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create();

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $expectedKeys = [
            'strength',
            'strengthModifier',
            'dexterity',
            'dexterityModifier',
            'constitution',
            'constitutionModifier',
            'intelligence',
            'intelligenceModifier',
            'wisdom',
            'wisdomModifier',
            'charisma',
            'charismaModifier',
        ];

        $this->assertSame(count($expectedKeys), count($resource));

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resource, "Resource should contain key: {$key}");
        }
    }

    // =====================================
    // Ability Scores Included Tests
    // =====================================

    public function testStrengthIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength' => 16,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('strength', $resource);
        $this->assertSame(16, $resource['strength']);
    }

    // =====================================
    // Computed Modifier Tests
    // =====================================

    public function testStrengthModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'strength' => 16,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('strengthModifier', $resource);
        $this->assertSame(3, $resource['strengthModifier']); // (16-10)/2 = 3
    }

    public function testWisdomIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'wisdom' => 10,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('wisdom', $resource);
        $this->assertSame(10, $resource['wisdom']);
    }

    public function testWisdomModifierIncluded(): void
    {
        $character    = Character::factory()->create();
        $abilityScore = AbilityScore::factory()->for($character)->create([
            'wisdom' => 10,
        ]);

        $resource = (new AbilityScoresResource($abilityScore))->toArray($this->makeRequest());

        $this->assertArrayHasKey('wisdomModifier', $resource);
        $this->assertSame(0, $resource['wisdomModifier']); // (10-10)/2 = 0
    }

    /**
     * Create a mock request for resource transformation.
     */
    private function makeRequest(): Request
    {
        return new Request();
    }
}
