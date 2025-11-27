<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Feat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feat>
 */
final class FeatFactory extends Factory
{
    protected $model = Feat::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Ability Score Improvement', 'Actor', 'Alert', 'Athlete', 'Axe Master', 'Blessed Warrior', 'Boon of the Nightwalker', 'Boon of Irresistible Offense', 'Charger', 'Crossbow Expert']),
            'description' => fake()->text(250),
            'prerequisites' => [fake()->randomElement(['4th level', 'Strength 13', 'Dexterity 13'])],
            'benefits' => [fake()->text(100), fake()->text(100)],
        ];
    }
}
