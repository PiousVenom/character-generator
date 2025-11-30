<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use App\Models\Subclass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Character>
 */
final class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function damaged(): self
    {
        return $this->state(static function (array $attributes): array {
            $maxHp = $attributes['max_hit_points'] ?? 10;

            return [
                'current_hit_points' => (int) ($maxHp / 2),
            ];
        });
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => $this->faker->name(),
            'class_id'          => CharacterClass::factory(),
            'subclass_id'       => null,
            'species_id'        => Species::factory(),
            'background_id'     => Background::factory(),
            'level'             => 1,
            'experience_points' => 0,
            'alignment'         => $this->faker->randomElement([
                'lawful-good',
                'neutral-good',
                'chaotic-good',
                'lawful-neutral',
                'neutral',
                'chaotic-neutral',
                'lawful-evil',
                'neutral-evil',
                'chaotic-evil',
            ]),
            'max_hit_points'       => $this->faker->numberBetween(6, 12),
            'current_hit_points'   => $this->faker->numberBetween(6, 12),
            'temporary_hit_points' => 0,
            'armor_class'          => $this->faker->numberBetween(10, 18),
            'proficiency_bonus'    => 2,
            'inspiration'          => false,
            'notes'                => null,
        ];
    }

    public function fullHealth(): self
    {
        return $this->state(static function (array $attributes): array {
            $maxHp = $attributes['max_hit_points'] ?? 10;

            return [
                'current_hit_points' => $maxHp,
            ];
        });
    }

    public function inspired(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'inspiration' => true,
        ]);
    }

    public function level(int $level): self
    {
        $proficiencyBonus = match (true) {
            $level <= 4  => 2,
            $level <= 8  => 3,
            $level <= 12 => 4,
            $level <= 16 => 5,
            default      => 6,
        };

        return $this->state(static fn (array $attributes): array => [
            'level'             => $level,
            'proficiency_bonus' => $proficiencyBonus,
        ]);
    }

    public function withSubclass(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'subclass_id' => Subclass::factory(),
            'level'       => max(3, $attributes['level'] ?? 1),
        ]);
    }
}
