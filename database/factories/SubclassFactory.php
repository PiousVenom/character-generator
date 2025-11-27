<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subclass>
 */
final class SubclassFactory extends Factory
{
    protected $model = Subclass::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => CharacterClass::factory(),
            'name' => fake()->words(2, true),
            'description' => fake()->text(200),
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
}
