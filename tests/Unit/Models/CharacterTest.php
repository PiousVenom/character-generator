<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CharacterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a character model can be created with a UUID.
     */
    public function test_character_model_generates_uuid(): void
    {
        $character = Character::factory()->create();

        $this->assertNotNull($character->id);
        $this->assertIsString($character->id);
        $this->assertStringMatchesFormat('%x-%x-%x-%x-%x', $character->id);
    }

    /**
     * Test that character UUID format is valid.
     */
    public function test_character_uuid_format_is_valid(): void
    {
        $character = Character::factory()->create();

        // UUID format: 8-4-4-4-12 hex characters
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $character->id,
        );
    }

    /**
     * Test that character belongs to a class.
     */
    public function test_character_belongs_to_class(): void
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(CharacterClass::class, $character->characterClass);
    }

    /**
     * Test that character belongs to a species.
     */
    public function test_character_belongs_to_species(): void
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(Species::class, $character->species);
    }

    /**
     * Test that character belongs to a background.
     */
    public function test_character_belongs_to_background(): void
    {
        $character = Character::factory()->create();

        $this->assertInstanceOf(Background::class, $character->background);
    }

    /**
     * Test that character has abilityScores relationship defined.
     */
    public function test_character_has_ability_scores_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'abilityScores'));
    }

    /**
     * Test that character can have multiple character levels for multiclassing.
     */
    public function test_character_has_character_levels_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'characterLevels'));
    }

    /**
     * Test that character can have skills relationship.
     */
    public function test_character_has_skills_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'skills'));
    }

    /**
     * Test that character can have equipment relationship.
     */
    public function test_character_has_equipment_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'equipment'));
    }

    /**
     * Test that character can have spells relationship.
     */
    public function test_character_has_spells_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'spells'));
    }

    /**
     * Test that character can have feats relationship.
     */
    public function test_character_has_feats_relationship(): void
    {
        $character = Character::factory()->make();

        $this->assertTrue(method_exists($character, 'feats'));
    }

    /**
     * Test that character has correct fillable attributes.
     */
    public function test_character_has_correct_fillable_attributes(): void
    {
        $character = Character::factory()->make();

        $fillable = $character->getFillable();

        $expectedAttributes = [
            'name',
            'class_id',
            'species_id',
            'background_id',
            'subclass_id',
            'level',
            'experience_points',
            'alignment',
            'max_hit_points',
            'current_hit_points',
            'temporary_hit_points',
            'armor_class',
            'initiative_bonus',
            'speed',
            'proficiency_bonus',
            'inspiration',
        ];

        foreach ($expectedAttributes as $attribute) {
            $this->assertContains($attribute, $fillable);
        }
    }

    /**
     * Test that character uses HasUuids trait.
     */
    public function test_character_uses_has_uuids_trait(): void
    {
        $character = new Character();

        $this->assertTrue(
            in_array('Illuminate\Database\Eloquent\Concerns\HasUuids', class_uses($character), true),
            'Character model should use HasUuids trait',
        );
    }

    /**
     * Test that character key type is string for UUID.
     */
    public function test_character_key_type_is_string(): void
    {
        $character = new Character();

        $this->assertEquals('string', $character->getKeyType());
    }

    /**
     * Test that character incrementing is false for UUID.
     */
    public function test_character_incrementing_is_false(): void
    {
        $character = new Character();

        $this->assertFalse($character->getIncrementing());
    }
}
