<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use App\Models\ClassFeature;
use App\Models\Subclass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClassFeature>
 */
final class ClassFeatureFactory extends Factory
{
    protected $model = ClassFeature::class;

    public function atLevel(int $level): self
    {
        return $this->state(static fn (array $attributes): array => [
            'level' => $level,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id'            => CharacterClass::factory(),
            'subclass_id'         => null,
            'name'                => $this->faker->unique()->words(3, true),
            'description'         => $this->faker->paragraph(),
            'level'               => $this->faker->numberBetween(1, 20),
            'is_subclass_feature' => false,
        ];
    }

    public function forSubclass(Subclass $subclass): self
    {
        return $this->state(static fn (array $attributes): array => [
            'class_id'            => $subclass->class_id,
            'subclass_id'         => $subclass->id,
            'is_subclass_feature' => true,
        ]);
    }

    public function subclassFeature(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'subclass_id'         => Subclass::factory(),
            'is_subclass_feature' => true,
        ]);
    }
}
