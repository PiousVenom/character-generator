<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Background;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Background>
 */
final class BackgroundFactory extends Factory
{
    protected $model = Background::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Acolyte', 'Charlatan', 'Criminal', 'Entertainer', 'Folk Hero', 'Gladiator', 'Guild Artisan', 'Hermit', 'Knight', 'Mercenary Veteran', 'Noble', 'Outlander', 'Sage', 'Sailor', 'Soldier', 'Urchin']),
            'description' => fake()->text(200),
            'skill_proficiencies' => [fake()->randomElement(['Acrobatics', 'Animal Handling', 'Arcana', 'Athletics'])],
            'tool_proficiencies' => [fake()->randomElement(['Thieves\' Tools', 'Alchemist\'s Supplies', 'Brewer\'s Supplies'])],
            'languages' => [fake()->randomElement(['Common', 'Elvish', 'Dwarvish'])],
            'starting_equipment' => [fake()->word(), fake()->word()],
            'feature_name' => 'Background Feature',
            'feature_description' => fake()->text(100),
        ];
    }
}
