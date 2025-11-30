<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Skill>
 */
final class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function acrobatics(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Acrobatics',
            'slug'        => 'acrobatics',
            'description' => 'Covers attempts to stay on your feet in tricky situations, stunts, and balance.',
            'ability'     => 'dexterity',
        ]);
    }

    public function arcana(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Arcana',
            'slug'        => 'arcana',
            'description' => 'Measures recall of lore about spells, magic items, planes, and magical creatures.',
            'ability'     => 'intelligence',
        ]);
    }

    public function athletics(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Athletics',
            'slug'        => 'athletics',
            'description' => 'Covers difficult physical situations: climbing, jumping, swimming, grappling.',
            'ability'     => 'strength',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $skills = [
            ['name' => 'Athletics', 'ability' => 'strength'],
            ['name' => 'Acrobatics', 'ability' => 'dexterity'],
            ['name' => 'Stealth', 'ability' => 'dexterity'],
            ['name' => 'Arcana', 'ability' => 'intelligence'],
            ['name' => 'Perception', 'ability' => 'wisdom'],
        ];

        $skill = $this->faker->randomElement($skills);

        return [
            'name'        => $skill['name'],
            'slug'        => Str::slug($skill['name']),
            'description' => $this->faker->paragraph(),
            'ability'     => $skill['ability'],
        ];
    }

    public function perception(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Perception',
            'slug'        => 'perception',
            'description' => 'Covers detecting presences, noticing details, and general awareness.',
            'ability'     => 'wisdom',
        ]);
    }

    public function stealth(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'name'        => 'Stealth',
            'slug'        => 'stealth',
            'description' => 'Covers attempts to hide and move quietly.',
            'ability'     => 'dexterity',
        ]);
    }
}
