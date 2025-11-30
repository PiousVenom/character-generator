<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use App\Models\Subclass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subclass>
 */
final class SubclassFactory extends Factory
{
    protected $model = Subclass::class;

    public function battleMaster(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Battle Master',
            'slug'        => 'battle-master',
            'description' => 'Those who emulate the archetypal Battle Master employ martial techniques passed down through generations.',
            'source'      => 'PHB 2024',
        ]);
    }

    public function champion(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Champion',
            'slug'        => 'champion',
            'description' => 'The archetypal Champion focuses on the development of raw physical power honed to deadly perfection.',
            'source'      => 'PHB 2024',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'class_id'    => CharacterClass::factory(),
            'name'        => ucwords($name),
            'slug'        => Str::slug($name),
            'description' => $this->faker->paragraph(),
            'source'      => 'PHB 2024',
        ];
    }

    public function lifeDomain(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Life Domain',
            'slug'        => 'life-domain',
            'description' => 'The Life domain focuses on the vibrant positive energy that sustains all life.',
            'source'      => 'PHB 2024',
        ]);
    }

    public function schoolOfEvocation(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'School of Evocation',
            'slug'        => 'school-of-evocation',
            'description' => 'You focus your study on magic that creates powerful elemental effects such as bitter cold, searing flame, rolling thunder, crackling lightning, and burning acid.',
            'source'      => 'PHB 2024',
        ]);
    }
}
