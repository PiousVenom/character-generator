<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EquipmentType;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
final class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Longsword', 'Shortsword', 'Dagger', 'Shield', 'Leather Armor', 'Plate Armor', 'Chain Mail', 'Rope', 'Bedroll', 'Backpack']),
            'type' => fake()->randomElement(EquipmentType::cases())->value,
            'description' => fake()->text(200),
            'cost_copper' => fake()->numberBetween(1, 10000),
            'weight' => fake()->randomFloat(2, 0.1, 100),
            'properties' => [fake()->word()],
            'weapon_properties' => fake()->boolean(50) ? [fake()->randomElement(['finesse', 'light', 'heavy', 'versatile'])] : [],
            'armor_properties' => fake()->boolean(50) ? ['armor_class' => fake()->numberBetween(10, 18)] : [],
            'requires_attunement' => fake()->boolean(20),
        ];
    }
}
