<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Spell;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Spell>
 */
final class SpellFactory extends Factory
{
    protected $model = Spell::class;

    public function cantrip(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'level'         => 0,
            'concentration' => false,
            'ritual'        => false,
        ]);
    }

    public function concentration(): self
    {
        return $this->state(fn (array $attributes): array => [
            'concentration' => true,
            'duration'      => 'Concentration, up to '.$this->faker->randomElement(['1 minute', '10 minutes', '1 hour']),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);

        return [
            'name'        => ucwords($name),
            'slug'        => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'level'       => $this->faker->numberBetween(0, 9),
            'school'      => $this->faker->randomElement([
                'abjuration',
                'conjuration',
                'divination',
                'enchantment',
                'evocation',
                'illusion',
                'necromancy',
                'transmutation',
            ]),
            'casting_time'                 => $this->faker->randomElement(['1 action', '1 bonus action', '1 reaction', '1 minute']),
            'range'                        => $this->faker->randomElement(['Self', 'Touch', '30 feet', '60 feet', '120 feet']),
            'components_verbal'            => $this->faker->boolean(80),
            'components_somatic'           => $this->faker->boolean(70),
            'components_material'          => $this->faker->optional(0.3)->sentence(),
            'components_material_cost'     => null,
            'components_material_consumed' => false,
            'duration'                     => $this->faker->randomElement(['Instantaneous', '1 round', '1 minute', '1 hour', 'Concentration, up to 1 minute']),
            'concentration'                => $this->faker->boolean(30),
            'ritual'                       => $this->faker->boolean(10),
            'higher_levels'                => $this->faker->optional(0.5)->sentence(),
        ];
    }

    public function fireball(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                         => 'Fireball',
            'slug'                         => 'fireball',
            'description'                  => 'A bright streak flashes from your pointing finger to a point you choose within range and then blossoms with a low roar into an explosion of flame.',
            'level'                        => 3,
            'school'                       => 'evocation',
            'casting_time'                 => '1 action',
            'range'                        => '150 feet',
            'components_verbal'            => true,
            'components_somatic'           => true,
            'components_material'          => 'A tiny ball of bat guano and sulfur',
            'components_material_cost'     => null,
            'components_material_consumed' => false,
            'duration'                     => 'Instantaneous',
            'concentration'                => false,
            'ritual'                       => false,
            'higher_levels'                => 'When you cast this spell using a spell slot of 4th level or higher, the damage increases by 1d6 for each slot level above 3rd.',
        ]);
    }

    public function light(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                => 'Light',
            'slug'                => 'light',
            'description'         => 'You touch one object that is no larger than 10 feet in any dimension. The object sheds bright light in a 20-foot radius and dim light for an additional 20 feet.',
            'level'               => 0,
            'school'              => 'evocation',
            'casting_time'        => '1 action',
            'range'               => 'Touch',
            'components_verbal'   => true,
            'components_somatic'  => false,
            'components_material' => 'A firefly or phosphorescent moss',
            'duration'            => '1 hour',
            'concentration'       => false,
            'ritual'              => false,
            'higher_levels'       => null,
        ]);
    }

    public function magicMissile(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                => 'Magic Missile',
            'slug'                => 'magic-missile',
            'description'         => 'You create three glowing darts of magical force.',
            'level'               => 1,
            'school'              => 'evocation',
            'casting_time'        => '1 action',
            'range'               => '120 feet',
            'components_verbal'   => true,
            'components_somatic'  => true,
            'components_material' => null,
            'duration'            => 'Instantaneous',
            'concentration'       => false,
            'ritual'              => false,
            'higher_levels'       => 'When you cast this spell using a spell slot of 2nd level or higher, the spell creates one more dart for each slot level above 1st.',
        ]);
    }

    public function ritual(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'ritual'       => true,
            'casting_time' => '1 minute',
        ]);
    }
}
