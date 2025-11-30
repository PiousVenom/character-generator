<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Feat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Feat>
 */
final class FeatFactory extends Factory
{
    protected $model = Feat::class;

    public function alert(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'          => 'Alert',
            'slug'          => 'alert',
            'description'   => 'Always on the lookout for danger, you gain the following benefits.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain a +5 bonus to initiative.',
                'You can\'t be surprised while you are conscious.',
                'Other creatures don\'t gain advantage on attack rolls against you as a result of being unseen by you.',
            ],
            'repeatable' => false,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name'          => ucwords($name),
            'slug'          => Str::slug($name),
            'description'   => $this->faker->paragraph(),
            'category'      => $this->faker->randomElement(['origin', 'general', 'fighting-style', 'epic-boon']),
            'prerequisites' => null,
            'benefits'      => [
                $this->faker->sentence(),
            ],
            'repeatable' => false,
        ];
    }

    public function general(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
        ]);
    }

    public function greatWeaponMaster(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'          => 'Great Weapon Master',
            'slug'          => 'great-weapon-master',
            'description'   => 'You\'ve learned to put the weight of a weapon to your advantage.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4, 'proficiency' => 'heavy-weapons'],
            'benefits'      => [
                'On your turn, when you score a critical hit or reduce a creature to 0 HP with a melee weapon, you can make one melee weapon attack as a bonus action.',
                'Before you make a melee attack with a heavy weapon, you can choose to take a -5 penalty to the attack roll. If the attack hits, you add +10 to the damage.',
            ],
            'repeatable' => false,
        ]);
    }

    public function lucky(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'          => 'Lucky',
            'slug'          => 'lucky',
            'description'   => 'You have inexplicable luck that seems to kick in at just the right moment.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You have 3 luck points.',
                'Whenever you make an attack roll, ability check, or saving throw, you can spend one luck point to roll an additional d20.',
                'You regain all expended luck points when you finish a long rest.',
            ],
            'repeatable' => false,
        ]);
    }

    public function origin(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'category'      => 'origin',
            'prerequisites' => null,
        ]);
    }

    public function tough(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'          => 'Tough',
            'slug'          => 'tough',
            'description'   => 'Your hit point maximum increases.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'Your hit point maximum increases by an amount equal to twice your level when you gain this feat.',
                'Whenever you gain a level thereafter, your hit point maximum increases by an additional 2 hit points.',
            ],
            'repeatable' => false,
        ]);
    }
}
