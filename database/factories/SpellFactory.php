<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SpellSchool;
use App\Models\Spell;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Spell>
 */
final class SpellFactory extends Factory
{
    protected $model = Spell::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Magic Missile', 'Fireball', 'Lightning Bolt', 'Healing Word', 'Shield', 'Counterspell', 'Cure Wounds', 'Detect Magic', 'Bless', 'Sleep']),
            'description' => fake()->text(300),
            'level' => fake()->numberBetween(0, 9),
            'school' => fake()->randomElement(SpellSchool::cases())->value,
            'casting_time' => fake()->randomElement(['1 action', '1 bonus action', '1 reaction', '1 minute']),
            'range' => fake()->randomElement(['Self', '30 feet', '60 feet', '120 feet', 'Touch']),
            'components' => [fake()->randomElement(['V', 'S', 'M'])],
            'duration' => fake()->randomElement(['Instantaneous', 'Concentration, up to 1 minute', 'Concentration, up to 10 minutes', '1 hour']),
            'concentration' => fake()->boolean(50),
            'ritual' => fake()->boolean(30),
        ];
    }
}
