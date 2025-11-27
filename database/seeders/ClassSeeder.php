<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CharacterClass;
use Illuminate\Database\Seeder;

final class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $classes = $this->getClassData();

        foreach ($classes as $classData) {
            CharacterClass::create($classData);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getClassData(): array
    {
        return [
            [
                'name' => 'Barbarian',
                'description' => 'A fierce warrior of primitive background who can enter a battle rage.',
                'hit_die' => 'd12',
                'primary_ability' => 'strength',
                'saving_throw_proficiencies' => ['strength', 'constitution'],
                'armor_proficiencies' => ['light', 'medium', 'shields'],
                'weapon_proficiencies' => ['simple', 'martial'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['animal_handling', 'athletics', 'intimidation', 'nature', 'perception', 'survival'],
                'spellcasting_ability' => null,
                'spell_slots_progression' => null,
            ],
            [
                'name' => 'Bard',
                'description' => 'An inspiring magician whose power echoes the music of creation.',
                'hit_die' => 'd8',
                'primary_ability' => 'charisma',
                'saving_throw_proficiencies' => ['dexterity', 'charisma'],
                'armor_proficiencies' => ['light'],
                'weapon_proficiencies' => ['simple', 'hand_crossbows', 'longswords', 'rapiers', 'shortswords'],
                'tool_proficiencies' => ['three_musical_instruments'],
                'skill_choices_count' => 3,
                'skill_choices_list' => ['acrobatics', 'animal_handling', 'arcana', 'athletics', 'deception', 'history', 'insight', 'intimidation', 'investigation', 'medicine', 'nature', 'perception', 'performance', 'persuasion', 'religion', 'sleight_of_hand', 'stealth', 'survival'],
                'spellcasting_ability' => 'charisma',
                'spell_slots_progression' => [
                    1 => ['1st' => 2],
                    2 => ['1st' => 3],
                    3 => ['1st' => 4, '2nd' => 2],
                    4 => ['1st' => 4, '2nd' => 3],
                    5 => ['1st' => 4, '2nd' => 3, '3rd' => 2],
                ],
            ],
            [
                'name' => 'Cleric',
                'description' => 'A priestly champion who wields divine magic in service of a higher power.',
                'hit_die' => 'd8',
                'primary_ability' => 'wisdom',
                'saving_throw_proficiencies' => ['wisdom', 'charisma'],
                'armor_proficiencies' => ['light', 'medium', 'shields'],
                'weapon_proficiencies' => ['simple'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['history', 'insight', 'medicine', 'persuasion', 'religion'],
                'spellcasting_ability' => 'wisdom',
                'spell_slots_progression' => [
                    1 => ['1st' => 2],
                    2 => ['1st' => 3],
                    3 => ['1st' => 4, '2nd' => 2],
                    4 => ['1st' => 4, '2nd' => 3],
                    5 => ['1st' => 4, '2nd' => 3, '3rd' => 2],
                ],
            ],
            [
                'name' => 'Druid',
                'description' => 'A priest of the Old Faith, wielding the powers of nature and adopting animal forms.',
                'hit_die' => 'd8',
                'primary_ability' => 'wisdom',
                'saving_throw_proficiencies' => ['intelligence', 'wisdom'],
                'armor_proficiencies' => ['light', 'medium', 'shields'],
                'weapon_proficiencies' => ['clubs', 'daggers', 'darts', 'javelins', 'maces', 'quarterstaffs', 'scimitars', 'sickles', 'slings', 'spears'],
                'tool_proficiencies' => ['herbalism_kit'],
                'skill_choices_count' => 2,
                'skill_choices_list' => ['arcana', 'animal_handling', 'insight', 'medicine', 'nature', 'perception', 'religion', 'survival'],
                'spellcasting_ability' => 'wisdom',
                'spell_slots_progression' => [
                    1 => ['1st' => 2],
                    2 => ['1st' => 3],
                    3 => ['1st' => 4, '2nd' => 2],
                    4 => ['1st' => 4, '2nd' => 3],
                    5 => ['1st' => 4, '2nd' => 3, '3rd' => 2],
                ],
            ],
            [
                'name' => 'Fighter',
                'description' => 'A master of martial combat, skilled with a variety of weapons and armor.',
                'hit_die' => 'd10',
                'primary_ability' => 'strength',
                'saving_throw_proficiencies' => ['strength', 'constitution'],
                'armor_proficiencies' => ['light', 'medium', 'heavy', 'shields'],
                'weapon_proficiencies' => ['simple', 'martial'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['acrobatics', 'animal_handling', 'athletics', 'history', 'insight', 'intimidation', 'perception', 'survival'],
                'spellcasting_ability' => null,
                'spell_slots_progression' => null,
            ],
            [
                'name' => 'Monk',
                'description' => 'A master of martial arts, harnessing the power of the body in pursuit of physical and spiritual perfection.',
                'hit_die' => 'd8',
                'primary_ability' => 'dexterity',
                'saving_throw_proficiencies' => ['strength', 'dexterity'],
                'armor_proficiencies' => [],
                'weapon_proficiencies' => ['simple', 'shortswords'],
                'tool_proficiencies' => ['one_artisan_tool_or_musical_instrument'],
                'skill_choices_count' => 2,
                'skill_choices_list' => ['acrobatics', 'athletics', 'history', 'insight', 'religion', 'stealth'],
                'spellcasting_ability' => null,
                'spell_slots_progression' => null,
            ],
            [
                'name' => 'Paladin',
                'description' => 'A holy warrior bound to a sacred oath.',
                'hit_die' => 'd10',
                'primary_ability' => 'strength',
                'saving_throw_proficiencies' => ['wisdom', 'charisma'],
                'armor_proficiencies' => ['light', 'medium', 'heavy', 'shields'],
                'weapon_proficiencies' => ['simple', 'martial'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['athletics', 'insight', 'intimidation', 'medicine', 'persuasion', 'religion'],
                'spellcasting_ability' => 'charisma',
                'spell_slots_progression' => [
                    2 => ['1st' => 2],
                    3 => ['1st' => 3],
                    4 => ['1st' => 3],
                    5 => ['1st' => 4, '2nd' => 2],
                ],
            ],
            [
                'name' => 'Ranger',
                'description' => 'A warrior who combats threats on the edges of civilization.',
                'hit_die' => 'd10',
                'primary_ability' => 'dexterity',
                'saving_throw_proficiencies' => ['strength', 'dexterity'],
                'armor_proficiencies' => ['light', 'medium', 'shields'],
                'weapon_proficiencies' => ['simple', 'martial'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 3,
                'skill_choices_list' => ['animal_handling', 'athletics', 'insight', 'investigation', 'nature', 'perception', 'stealth', 'survival'],
                'spellcasting_ability' => 'wisdom',
                'spell_slots_progression' => [
                    2 => ['1st' => 2],
                    3 => ['1st' => 3],
                    4 => ['1st' => 3],
                    5 => ['1st' => 4, '2nd' => 2],
                ],
            ],
            [
                'name' => 'Rogue',
                'description' => 'A scoundrel who uses stealth and trickery to overcome obstacles and enemies.',
                'hit_die' => 'd8',
                'primary_ability' => 'dexterity',
                'saving_throw_proficiencies' => ['dexterity', 'intelligence'],
                'armor_proficiencies' => ['light'],
                'weapon_proficiencies' => ['simple', 'hand_crossbows', 'longswords', 'rapiers', 'shortswords'],
                'tool_proficiencies' => ['thieves_tools'],
                'skill_choices_count' => 4,
                'skill_choices_list' => ['acrobatics', 'athletics', 'deception', 'insight', 'intimidation', 'investigation', 'perception', 'performance', 'persuasion', 'sleight_of_hand', 'stealth'],
                'spellcasting_ability' => null,
                'spell_slots_progression' => null,
            ],
            [
                'name' => 'Sorcerer',
                'description' => 'A spellcaster who draws on inherent magic from a gift or bloodline.',
                'hit_die' => 'd6',
                'primary_ability' => 'charisma',
                'saving_throw_proficiencies' => ['constitution', 'charisma'],
                'armor_proficiencies' => [],
                'weapon_proficiencies' => ['daggers', 'darts', 'slings', 'quarterstaffs', 'light_crossbows'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['arcana', 'deception', 'insight', 'intimidation', 'persuasion', 'religion'],
                'spellcasting_ability' => 'charisma',
                'spell_slots_progression' => [
                    1 => ['1st' => 2],
                    2 => ['1st' => 3],
                    3 => ['1st' => 4, '2nd' => 2],
                    4 => ['1st' => 4, '2nd' => 3],
                    5 => ['1st' => 4, '2nd' => 3, '3rd' => 2],
                ],
            ],
            [
                'name' => 'Warlock',
                'description' => 'A wielder of magic that is derived from a bargain with an extraplanar entity.',
                'hit_die' => 'd8',
                'primary_ability' => 'charisma',
                'saving_throw_proficiencies' => ['wisdom', 'charisma'],
                'armor_proficiencies' => ['light'],
                'weapon_proficiencies' => ['simple'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['arcana', 'deception', 'history', 'intimidation', 'investigation', 'nature', 'religion'],
                'spellcasting_ability' => 'charisma',
                'spell_slots_progression' => [
                    1 => ['1st' => 1],
                    2 => ['1st' => 2],
                    3 => ['2nd' => 2],
                    4 => ['2nd' => 2],
                    5 => ['3rd' => 2],
                ],
            ],
            [
                'name' => 'Wizard',
                'description' => 'A scholarly magic-user capable of manipulating the structures of reality.',
                'hit_die' => 'd6',
                'primary_ability' => 'intelligence',
                'saving_throw_proficiencies' => ['intelligence', 'wisdom'],
                'armor_proficiencies' => [],
                'weapon_proficiencies' => ['daggers', 'darts', 'slings', 'quarterstaffs', 'light_crossbows'],
                'tool_proficiencies' => null,
                'skill_choices_count' => 2,
                'skill_choices_list' => ['arcana', 'history', 'insight', 'investigation', 'medicine', 'religion'],
                'spellcasting_ability' => 'intelligence',
                'spell_slots_progression' => [
                    1 => ['1st' => 2],
                    2 => ['1st' => 3],
                    3 => ['1st' => 4, '2nd' => 2],
                    4 => ['1st' => 4, '2nd' => 3],
                    5 => ['1st' => 4, '2nd' => 3, '3rd' => 2],
                ],
            ],
        ];
    }
}
