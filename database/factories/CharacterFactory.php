<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Alignment;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Character>
 */
final class CharacterFactory extends Factory
{
    protected $model = Character::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'class_id' => CharacterClass::factory(),
            'species_id' => Species::factory(),
            'background_id' => Background::factory(),
            'level' => 1,
            'experience_points' => 0,
            'alignment' => fake()->randomElement(Alignment::cases())->value,
            'max_hit_points' => 10,
            'current_hit_points' => 10,
            'temporary_hit_points' => 0,
            'armor_class' => 10,
            'initiative_bonus' => 0,
            'speed' => 30,
            'proficiency_bonus' => 2,
            'inspiration' => false,
        ];
    }

    /**
     * Set a specific level for the character.
     */
    public function level(int $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level' => $level,
            'proficiency_bonus' => $this->calculateProficiencyBonus($level),
        ]);
    }

    /**
     * Associate a specific character class.
     */
    public function withClass(CharacterClass $class): static
    {
        return $this->state(fn (array $attributes) => [
            'class_id' => $class->id,
        ]);
    }

    /**
     * Associate a specific species.
     */
    public function withSpecies(Species $species): static
    {
        return $this->state(fn (array $attributes) => [
            'species_id' => $species->id,
        ]);
    }

    /**
     * Associate a specific background.
     */
    public function withBackground(Background $background): static
    {
        return $this->state(fn (array $attributes) => [
            'background_id' => $background->id,
        ]);
    }

    /**
     * Set a specific alignment.
     */
    public function withAlignment(Alignment $alignment): static
    {
        return $this->state(fn (array $attributes) => [
            'alignment' => $alignment->value,
        ]);
    }

    /**
     * Give the character inspiration.
     */
    public function withInspiration(): static
    {
        return $this->state(fn (array $attributes) => [
            'inspiration' => true,
        ]);
    }

    /**
     * Set specific hit points.
     */
    public function withHitPoints(int $maxHp, ?int $currentHp = null): static
    {
        return $this->state(fn (array $attributes) => [
            'max_hit_points' => $maxHp,
            'current_hit_points' => $currentHp ?? $maxHp,
        ]);
    }

    /**
     * Set armor class.
     */
    public function withArmorClass(int $ac): static
    {
        return $this->state(fn (array $attributes) => [
            'armor_class' => $ac,
        ]);
    }

    /**
     * Calculate proficiency bonus based on level.
     */
    private function calculateProficiencyBonus(int $level): int
    {
        return (int) ceil($level / 4) + 1;
    }
}
