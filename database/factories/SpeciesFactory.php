<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Species>
 */
final class SpeciesFactory extends Factory
{
    protected $model = Species::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Human', 'Elf', 'Dwarf', 'Halfling', 'Dragonborn', 'Gnome', 'Half-Elf', 'Half-Orc', 'Tiefling', 'Kobold']),
            'description' => fake()->text(200),
            'size' => fake()->randomElement(['Tiny', 'Small', 'Medium', 'Large', 'Huge']),
            'speed' => fake()->randomElement([25, 30, 35]),
            'ability_score_increases' => [
                fake()->randomElement(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma']) => 2,
            ],
            'languages' => [fake()->randomElement(['Common', 'Elvish', 'Dwarvish', 'Halfling'])],
            'traits' => [fake()->word()],
        ];
    }
}
