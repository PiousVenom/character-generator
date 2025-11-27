<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AbilityScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AbilityScore>
 */
final class AbilityScoreFactory extends Factory
{
    protected $model = AbilityScore::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'strength' => fake()->numberBetween(3, 18),
            'dexterity' => fake()->numberBetween(3, 18),
            'constitution' => fake()->numberBetween(3, 18),
            'intelligence' => fake()->numberBetween(3, 18),
            'wisdom' => fake()->numberBetween(3, 18),
            'charisma' => fake()->numberBetween(3, 18),
        ];
    }
}
