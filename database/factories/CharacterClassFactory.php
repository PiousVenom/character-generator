<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CharacterClass>
 */
final class CharacterClassFactory extends Factory
{
    protected $model = CharacterClass::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->randomElement([
            'Test Fighter',
            'Test Wizard',
            'Test Rogue',
            'Test Cleric',
            'Test Barbarian',
        ]);

        return [
            'name'                       => $name,
            'slug'                       => Str::slug($name),
            'description'                => $this->faker->paragraph(),
            'hit_die'                    => $this->faker->randomElement([6, 8, 10, 12]),
            'primary_abilities'          => [$this->faker->randomElement(['strength', 'dexterity', 'intelligence', 'wisdom', 'charisma'])],
            'saving_throw_proficiencies' => $this->faker->randomElements(
                ['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'],
                2
            ),
            'armor_proficiencies'  => ['light'],
            'weapon_proficiencies' => ['simple'],
            'tool_proficiencies'   => [],
            'skill_choices'        => ['count' => 2, 'options' => ['acrobatics', 'athletics', 'perception', 'stealth']],
            'starting_equipment'   => [],
            'spellcasting_ability' => null,
            'subclass_level'       => 3,
        ];
    }

    public function fighter(): self
    {
        return $this->state(function (array $attributes): array {
            $_ = $this; // Prevent static closure - Laravel binds $this to state callbacks

            return [
                'name'                       => 'Fighter',
                'slug'                       => 'fighter',
                'hit_die'                    => 10,
                'primary_abilities'          => ['strength', 'dexterity'],
                'saving_throw_proficiencies' => ['strength', 'constitution'],
                'armor_proficiencies'        => ['light', 'medium', 'heavy', 'shields'],
                'weapon_proficiencies'       => ['simple', 'martial'],
                'skill_choices'              => ['count' => 2, 'options' => ['acrobatics', 'animal-handling', 'athletics', 'history', 'insight', 'intimidation', 'perception', 'survival']],
                'starting_equipment'         => [],
                'spellcasting_ability'       => null,
                'subclass_level'             => 3,
            ];
        });
    }

    public function spellcaster(): self
    {
        return $this->state(fn (array $attributes): array => [
            'spellcasting_ability' => $this->faker->randomElement(['intelligence', 'wisdom', 'charisma']),
        ]);
    }

    public function wizard(): self
    {
        return $this->state(function (array $attributes): array {
            $_ = $this; // Prevent static closure - Laravel binds $this to state callbacks

            return [
                'name'                       => 'Wizard',
                'slug'                       => 'wizard',
                'hit_die'                    => 6,
                'primary_abilities'          => ['intelligence'],
                'saving_throw_proficiencies' => ['intelligence', 'wisdom'],
                'armor_proficiencies'        => [],
                'weapon_proficiencies'       => ['daggers', 'darts', 'slings', 'quarterstaffs', 'light-crossbows'],
                'skill_choices'              => ['count' => 2, 'options' => ['arcana', 'history', 'insight', 'investigation', 'medicine', 'religion']],
                'starting_equipment'         => [],
                'spellcasting_ability'       => 'intelligence',
                'subclass_level'             => 3,
            ];
        });
    }
}
