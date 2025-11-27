<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CharacterClass;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'name' => fake()->randomElement(['Barbarian', 'Bard', 'Cleric', 'Druid', 'Fighter', 'Monk', 'Paladin', 'Ranger', 'Rogue', 'Sorcerer', 'Warlock', 'Wizard']),
            'description' => fake()->text(200),
            'hit_die' => fake()->randomElement([6, 8, 10, 12]),
            'primary_ability' => fake()->randomElement(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma']),
            'saving_throw_proficiencies' => [fake()->randomElement(['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'])],
            'armor_proficiencies' => ['light armor', 'medium armor'],
            'weapon_proficiencies' => ['simple melee weapons', 'martial melee weapons'],
            'tool_proficiencies' => [],
            'skill_choices_count' => 2,
            'skill_choices_list' => ['Acrobatics', 'Animal Handling', 'Arcana', 'Athletics'],
            'spellcasting_ability' => fake()->randomElement(['intelligence', 'wisdom', 'charisma']),
            'spell_slots_progression' => [],
        ];
    }
}
