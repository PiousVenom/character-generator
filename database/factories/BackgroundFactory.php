<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Background;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Background>
 */
final class BackgroundFactory extends Factory
{
    protected $model = Background::class;

    public function criminal(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                => 'Criminal',
            'slug'                => 'criminal',
            'skill_proficiencies' => ['sleight-of-hand', 'stealth'],
            'tool_proficiency'    => 'thieves-tools',
            'starting_equipment'  => [
                ['item' => 'Dagger', 'quantity' => 2],
                ['item' => 'Thieves\' Tools', 'quantity' => 1],
                ['item' => 'Crowbar', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold' => 16.00,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Test Soldier',
            'Test Sage',
            'Test Criminal',
            'Test Acolyte',
            'Test Noble',
        ]);

        return [
            'name'                => $name,
            'slug'                => Str::slug($name),
            'description'         => $this->faker->paragraph(),
            'skill_proficiencies' => $this->faker->randomElements(
                ['athletics', 'perception', 'stealth', 'insight', 'history'],
                2
            ),
            'tool_proficiency' => $this->faker->randomElement([
                'thieves-tools',
                'gaming-set',
                'calligraphers-supplies',
            ]),
            'starting_equipment' => [
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 1],
            ],
            'starting_gold' => $this->faker->randomFloat(2, 10, 30),
        ];
    }

    public function sage(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                => 'Sage',
            'slug'                => 'sage',
            'skill_proficiencies' => ['arcana', 'history'],
            'tool_proficiency'    => 'calligraphers-supplies',
            'starting_equipment'  => [
                ['item' => 'Calligrapher\'s Supplies', 'quantity' => 1],
                ['item' => 'Book', 'quantity' => 1],
                ['item' => 'Parchment', 'quantity' => 8],
                ['item' => 'Robe', 'quantity' => 1],
            ],
            'starting_gold' => 8.00,
        ]);
    }

    public function soldier(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                => 'Soldier',
            'slug'                => 'soldier',
            'skill_proficiencies' => ['athletics', 'intimidation'],
            'tool_proficiency'    => 'gaming-set',
            'starting_equipment'  => [
                ['item' => 'Spear', 'quantity' => 1],
                ['item' => 'Shortbow', 'quantity' => 1],
                ['item' => 'Arrow', 'quantity' => 20],
                ['item' => 'Gaming Set', 'quantity' => 1],
                ['item' => 'Healer\'s Kit', 'quantity' => 1],
                ['item' => 'Quiver', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold' => 14.00,
        ]);
    }
}
