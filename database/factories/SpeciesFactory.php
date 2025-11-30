<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Species;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = $this->faker->unique()->randomElement([
            'Test Human',
            'Test Elf',
            'Test Dwarf',
            'Test Halfling',
            'Test Tiefling',
        ]);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => $this->faker->paragraph(),
            'size'          => $this->faker->randomElement(['Small', 'Medium']),
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => $this->faker->optional(0.7)->randomElement([60, 120]),
            'traits'        => [
                [
                    'name'        => 'Test Trait',
                    'description' => $this->faker->sentence(),
                ],
            ],
            'languages'             => ['Common'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ];
    }

    public function dwarf(): self
    {
        return $this->state(function (array $attributes): array {
            $_ = $this; // Prevent static closure - Laravel binds $this to state callbacks

            return [
                'name'       => 'Dwarf',
                'slug'       => 'dwarf',
                'size'       => 'Medium',
                'speed'      => 30,
                'darkvision' => 120,
                'traits'     => [
                    ['name' => 'Dwarven Resilience', 'description' => 'Resistance to Poison damage; advantage on saves vs. poisoned.'],
                    ['name' => 'Dwarven Toughness', 'description' => 'HP maximum increases by 1 per level.'],
                    ['name' => 'Stonecunning', 'description' => 'Tremorsense 60 ft as bonus action.'],
                ],
                'languages'          => ['Common', 'Dwarvish'],
                'has_lineage_choice' => false,
            ];
        });
    }

    public function elf(): self
    {
        return $this->state(function (array $attributes): array {
            $_ = $this; // Prevent static closure - Laravel binds $this to state callbacks

            return [
                'name'       => 'Elf',
                'slug'       => 'elf',
                'size'       => 'Medium',
                'speed'      => 30,
                'darkvision' => 60,
                'traits'     => [
                    ['name' => 'Fey Ancestry', 'description' => 'Advantage on saves vs. charmed; magic cannot put you to sleep.'],
                    ['name' => 'Keen Senses', 'description' => 'Proficiency in Perception.'],
                    ['name' => 'Trance', 'description' => '4 hours of trance replaces 8 hours of sleep.'],
                ],
                'languages'          => ['Common', 'Elvish'],
                'has_lineage_choice' => true,
                'lineages'           => [
                    ['name' => 'Drow', 'description' => '120 ft darkvision; Dancing Lights cantrip.'],
                    ['name' => 'High Elf', 'description' => 'One Wizard cantrip; one extra language.'],
                    ['name' => 'Wood Elf', 'description' => '35 ft speed; Stealth proficiency.'],
                ],
            ];
        });
    }

    public function human(): self
    {
        return $this->state(function (array $attributes): array {
            $_ = $this; // Prevent static closure - Laravel binds $this to state callbacks

            return [
                'name'       => 'Human',
                'slug'       => 'human',
                'size'       => 'Medium',
                'speed'      => 30,
                'darkvision' => null,
                'traits'     => [
                    ['name' => 'Resourceful', 'description' => 'Gain Heroic Inspiration when you finish a long rest.'],
                    ['name' => 'Skillful', 'description' => 'Proficiency in one skill of your choice.'],
                    ['name' => 'Versatile', 'description' => 'Choose one Origin feat for which you qualify.'],
                ],
                'languages'          => ['Common'],
                'has_lineage_choice' => false,
            ];
        });
    }
}
