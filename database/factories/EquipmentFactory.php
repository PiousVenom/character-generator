<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Equipment>
 */
final class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function armor(): self
    {
        return $this->state(fn (array $attributes): array => [
            'equipment_type'       => 'armor',
            'equipment_subtype'    => $this->faker->randomElement(['light', 'medium', 'heavy']),
            'armor_class'          => $this->faker->numberBetween(11, 18),
            'armor_dex_cap'        => $this->faker->randomElement([null, 0, 2]),
            'stealth_disadvantage' => $this->faker->boolean(),
            'properties'           => [],
        ]);
    }

    public function chainMail(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                 => 'Chain Mail',
            'slug'                 => 'chain-mail',
            'description'          => 'Made of interlocking metal rings.',
            'equipment_type'       => 'armor',
            'equipment_subtype'    => 'heavy',
            'cost_cp'              => 7500,
            'weight_lb'            => 55.0,
            'armor_class'          => 16,
            'armor_dex_cap'        => 0,
            'strength_requirement' => 13,
            'stealth_disadvantage' => true,
            'properties'           => [],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'name'              => ucwords($name),
            'slug'              => Str::slug($name),
            'description'       => $this->faker->paragraph(),
            'equipment_type'    => $this->faker->randomElement(['weapon', 'armor', 'gear', 'tool']),
            'equipment_subtype' => null,
            'cost_cp'           => $this->faker->numberBetween(1, 10000),
            'weight_lb'         => $this->faker->randomFloat(2, 0, 20),
            'properties'        => [],
        ];
    }

    public function gear(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'equipment_type'    => 'gear',
            'equipment_subtype' => 'adventuring',
            'properties'        => [],
        ]);
    }

    public function longsword(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'              => 'Longsword',
            'slug'              => 'longsword',
            'description'       => 'A versatile sword favored by many warriors.',
            'equipment_type'    => 'weapon',
            'equipment_subtype' => 'martial-melee',
            'cost_cp'           => 1500,
            'weight_lb'         => 3.0,
            'damage_dice'       => '1d8',
            'damage_type'       => 'slashing',
            'properties'        => ['versatile-1d10'],
        ]);
    }

    public function shield(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'                 => 'Shield',
            'slug'                 => 'shield',
            'description'          => 'A wooden or metal shield carried in one hand.',
            'equipment_type'       => 'armor',
            'equipment_subtype'    => 'shield',
            'cost_cp'              => 1000,
            'weight_lb'            => 6.0,
            'armor_class'          => 2,
            'stealth_disadvantage' => false,
            'properties'           => [],
        ]);
    }

    public function tool(): self
    {
        return $this->state(fn (array $attributes): array => [
            'equipment_type'    => 'tool',
            'equipment_subtype' => $this->faker->randomElement(['artisan', 'gaming', 'musical', 'other']),
            'properties'        => [],
        ]);
    }

    public function weapon(): self
    {
        return $this->state(fn (array $attributes): array => [
            'equipment_type'    => 'weapon',
            'equipment_subtype' => $this->faker->randomElement(['simple-melee', 'simple-ranged', 'martial-melee', 'martial-ranged']),
            'damage_dice'       => '1d8',
            'damage_type'       => $this->faker->randomElement(['slashing', 'piercing', 'bludgeoning']),
            'properties'        => [],
        ]);
    }
}
