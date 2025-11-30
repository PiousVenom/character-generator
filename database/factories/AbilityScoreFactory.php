<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AbilityScore;
use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AbilityScore>
 */
final class AbilityScoreFactory extends Factory
{
    protected $model = AbilityScore::class;

    public function allTens(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'strength'     => 10,
            'dexterity'    => 10,
            'constitution' => 10,
            'intelligence' => 10,
            'wisdom'       => 10,
            'charisma'     => 10,
        ]);
    }

    public function cleric(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'strength'     => 14,
            'dexterity'    => 10,
            'constitution' => 13,
            'intelligence' => 8,
            'wisdom'       => 16,
            'charisma'     => 12,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'character_id' => Character::factory(),
            'strength'     => $this->faker->numberBetween(8, 18),
            'dexterity'    => $this->faker->numberBetween(8, 18),
            'constitution' => $this->faker->numberBetween(8, 18),
            'intelligence' => $this->faker->numberBetween(8, 18),
            'wisdom'       => $this->faker->numberBetween(8, 18),
            'charisma'     => $this->faker->numberBetween(8, 18),
        ];
    }

    public function fighter(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'strength'     => 16,
            'dexterity'    => 14,
            'constitution' => 15,
            'intelligence' => 10,
            'wisdom'       => 12,
            'charisma'     => 8,
        ]);
    }

    public function pointBuy(): self
    {
        return $this->state(fn (array $attributes): array => [
            'strength'     => $this->faker->numberBetween(8, 15),
            'dexterity'    => $this->faker->numberBetween(8, 15),
            'constitution' => $this->faker->numberBetween(8, 15),
            'intelligence' => $this->faker->numberBetween(8, 15),
            'wisdom'       => $this->faker->numberBetween(8, 15),
            'charisma'     => $this->faker->numberBetween(8, 15),
        ]);
    }

    public function rogue(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'strength'     => 10,
            'dexterity'    => 16,
            'constitution' => 13,
            'intelligence' => 12,
            'wisdom'       => 14,
            'charisma'     => 8,
        ]);
    }

    public function standardArray(): self
    {
        return $this->state(static function (array $attributes): array {
            $scores = [15, 14, 13, 12, 10, 8];
            shuffle($scores);

            return [
                'strength'     => $scores[0],
                'dexterity'    => $scores[1],
                'constitution' => $scores[2],
                'intelligence' => $scores[3],
                'wisdom'       => $scores[4],
                'charisma'     => $scores[5],
            ];
        });
    }

    public function wizard(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'strength'     => 8,
            'dexterity'    => 14,
            'constitution' => 13,
            'intelligence' => 16,
            'wisdom'       => 12,
            'charisma'     => 10,
        ]);
    }
}
