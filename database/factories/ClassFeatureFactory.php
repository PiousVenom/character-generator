<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use App\Models\ClassFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClassFeature>
 */
final class ClassFeatureFactory extends Factory
{
    protected $model = ClassFeature::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => CharacterClass::factory(),
            'subclass_id' => null,
            'name' => fake()->words(3, true),
            'description' => fake()->text(200),
            'level_acquired' => fake()->numberBetween(1, 20),
        ];
    }

    /**
     * Associate a specific class.
     */
    public function forClass(CharacterClass $class): static
    {
        return $this->state(fn (array $attributes) => [
            'class_id' => $class->id,
        ]);
    }

    /**
     * Set a specific level.
     */
    public function atLevel(int $level): static
    {
        return $this->state(fn (array $attributes) => [
            'level_acquired' => $level,
        ]);
    }
}
