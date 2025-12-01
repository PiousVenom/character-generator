<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Resources;

use App\Http\Resources\CharacterResource;
use App\Models\AbilityScore;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Unit tests for CharacterResource transformation.
 */
final class CharacterResourceTest extends TestCase
{
    use RefreshDatabase;

    public function testAlignmentIncluded(): void
    {
        $character = Character::factory()->create(['alignment' => 'lawful_good']);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('alignment', $resource);
        $this->assertSame('lawful_good', $resource['alignment']);
    }

    public function testArmorClassTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'armor_class' => 16,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('armorClass', $resource);
        $this->assertSame(16, $resource['armorClass']);
    }

    // =====================================
    // Date Formatting Tests
    // =====================================

    public function testCreatedAtIsIso8601Format(): void
    {
        $character = Character::factory()->create();

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('createdAt', $resource);
        $this->assertIsString($resource['createdAt']);
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
            $resource['createdAt']
        );
    }

    public function testCurrentHitPointsTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'current_hit_points' => 30,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('currentHitPoints', $resource);
        $this->assertSame(30, $resource['currentHitPoints']);
    }

    // =====================================
    // snake_case to camelCase Tests
    // =====================================

    public function testExperiencePointsTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'experience_points' => 1000,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('experiencePoints', $resource);
        $this->assertSame(1000, $resource['experiencePoints']);
        $this->assertArrayNotHasKey('experience_points', $resource);
    }

    // =====================================
    // Core Fields Tests
    // =====================================

    public function testIdIncluded(): void
    {
        $character = Character::factory()->create();

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('id', $resource);
        $this->assertSame($character->id, $resource['id']);
    }

    public function testInitiativeBonusTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'initiative_bonus' => 3,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('initiativeBonus', $resource);
        $this->assertSame(3, $resource['initiativeBonus']);
    }

    public function testLevelIncluded(): void
    {
        $character = Character::factory()->create(['level' => 5]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('level', $resource);
        $this->assertSame(5, $resource['level']);
    }

    public function testLoadedAbilityScoresRelationshipIncluded(): void
    {
        $character = Character::factory()->create();
        AbilityScore::factory()->for($character)->create([
            'strength' => 16,
        ]);
        $character->load('abilityScores');

        $characterResource = new CharacterResource($character);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $characterResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('abilityScores', $data);
        $this->assertIsArray($data['abilityScores']);
        /** @var array<string, int> $abilityScores */
        $abilityScores = $data['abilityScores'];
        $this->assertSame(16, $abilityScores['strength']);
    }

    public function testLoadedBackgroundRelationshipIncluded(): void
    {
        $background = Background::factory()->create(['name' => 'Soldier']);
        $character  = Character::factory()->create(['background_id' => $background->id]);
        $character->load('background');

        $characterResource = new CharacterResource($character);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $characterResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('background', $data);
        $this->assertIsArray($data['background']);
        /** @var array<string, string> $background */
        $background = $data['background'];
        $this->assertSame('Soldier', $background['name']);
    }

    // =====================================
    // whenLoaded() Behavior Tests
    // =====================================

    public function testLoadedClassRelationshipIncluded(): void
    {
        $class     = CharacterClass::factory()->create(['name' => 'Fighter']);
        $character = Character::factory()->create(['class_id' => $class->id]);
        $character->load('class');

        $characterResource = new CharacterResource($character);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $characterResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('class', $data);
        $this->assertIsArray($data['class']);
        /** @var array<string, string> $classData */
        $classData = $data['class'];
        $this->assertSame('Fighter', $classData['name']);
    }

    public function testLoadedSpeciesRelationshipIncluded(): void
    {
        $species   = Species::factory()->create(['name' => 'Elf']);
        $character = Character::factory()->create(['species_id' => $species->id]);
        $character->load('species');

        $characterResource = new CharacterResource($character);
        /** @var array{data: array<string, mixed>} $jsonResponse */
        $jsonResponse = $characterResource->response()->getData(true);
        /** @var array<string, mixed> $data */
        $data = $jsonResponse['data'];

        $this->assertArrayHasKey('species', $data);
        $this->assertIsArray($data['species']);
        /** @var array<string, string> $speciesData */
        $speciesData = $data['species'];
        $this->assertSame('Elf', $speciesData['name']);
    }

    public function testMaxHitPointsTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'max_hit_points' => 45,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('maxHitPoints', $resource);
        $this->assertSame(45, $resource['maxHitPoints']);
    }

    public function testNameIncluded(): void
    {
        $character = Character::factory()->create(['name' => 'Aragorn']);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('name', $resource);
        $this->assertSame('Aragorn', $resource['name']);
    }

    public function testPersonalityTraitsTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'personality_traits' => 'Brave and bold',
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('personalityTraits', $resource);
        $this->assertSame('Brave and bold', $resource['personalityTraits']);
    }

    public function testProficiencyBonusTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'proficiency_bonus' => 2,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('proficiencyBonus', $resource);
        $this->assertSame(2, $resource['proficiencyBonus']);
    }

    // =====================================
    // Complete Resource Structure Tests
    // =====================================

    public function testResourceContainsAllExpectedKeys(): void
    {
        $character = Character::factory()->create();

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $expectedKeys = [
            'id',
            'name',
            'level',
            'experiencePoints',
            'maxHitPoints',
            'currentHitPoints',
            'temporaryHitPoints',
            'armorClass',
            'initiativeBonus',
            'speed',
            'proficiencyBonus',
            'inspiration',
            'alignment',
            'personalityTraits',
            'ideals',
            'bonds',
            'flaws',
            'backstory',
            'notes',
            'class',
            'species',
            'background',
            'abilityScores',
            'skills',
            'equipment',
            'spells',
            'feats',
            'createdAt',
            'updatedAt',
        ];

        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $resource, "Resource should contain key: {$key}");
        }
    }

    public function testTemporaryHitPointsTransformedToCamelCase(): void
    {
        $character = Character::factory()->create([
            'temporary_hit_points' => 10,
        ]);

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('temporaryHitPoints', $resource);
        $this->assertSame(10, $resource['temporaryHitPoints']);
    }

    public function testUpdatedAtIsIso8601Format(): void
    {
        $character = Character::factory()->create();

        $resource = (new CharacterResource($character))->toArray($this->makeRequest());

        $this->assertArrayHasKey('updatedAt', $resource);
        $this->assertIsString($resource['updatedAt']);
        $this->assertMatchesRegularExpression(
            '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}/',
            $resource['updatedAt']
        );
    }

    /**
     * Create a mock request for resource transformation.
     */
    private function makeRequest(): Request
    {
        return new Request();
    }
}
