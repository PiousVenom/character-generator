<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

final class SpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $species = $this->getSpeciesData();

        foreach ($species as $speciesData) {
            Species::create($speciesData);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getSpeciesData(): array
    {
        return [
            [
                'name' => 'Human',
                'description' => 'In the reckonings of most worlds, humans are the youngest of the common races, late to arrive on the world scene and short-lived in comparison to dwarves, elves, and dragons.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'type' => 'choice',
                    'choices' => 2,
                    'amount' => 1,
                ],
                'languages' => ['Common', 'one_extra'],
                'traits' => [
                    'Versatile' => 'You gain proficiency in one skill of your choice.',
                    'Human Determination' => 'When you make an attack roll, an ability check, or a saving throw, you can do so with advantage. Once you use this trait, you can\'t use it again until you finish a long rest.',
                ],
            ],
            [
                'name' => 'Elf',
                'description' => 'Elves are a magical people of otherworldly grace, living in the world but not entirely part of it.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'dexterity' => 2,
                ],
                'languages' => ['Common', 'Elvish'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Keen Senses' => 'You have proficiency in the Perception skill.',
                    'Fey Ancestry' => 'You have advantage on saving throws against being charmed, and magic can\'t put you to sleep.',
                    'Trance' => 'Elves don\'t need to sleep. Instead, they meditate deeply, remaining semiconscious, for 4 hours a day.',
                ],
            ],
            [
                'name' => 'Dwarf',
                'description' => 'Bold and hardy, dwarves are known as skilled warriors, miners, and workers of stone and metal.',
                'size' => 'Medium',
                'speed' => 25,
                'ability_score_increases' => [
                    'constitution' => 2,
                ],
                'languages' => ['Common', 'Dwarvish'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Dwarven Resilience' => 'You have advantage on saving throws against poison, and you have resistance against poison damage.',
                    'Dwarven Combat Training' => 'You have proficiency with the battleaxe, handaxe, light hammer, and warhammer.',
                    'Stonecunning' => 'Whenever you make an Intelligence (History) check related to the origin of stonework, you are considered proficient in the History skill and add double your proficiency bonus to the check.',
                ],
            ],
            [
                'name' => 'Halfling',
                'description' => 'The diminutive halflings survive in a world full of larger creatures by avoiding notice or, barring that, avoiding offense.',
                'size' => 'Small',
                'speed' => 25,
                'ability_score_increases' => [
                    'dexterity' => 2,
                ],
                'languages' => ['Common', 'Halfling'],
                'traits' => [
                    'Lucky' => 'When you roll a 1 on the d20 for an attack roll, ability check, or saving throw, you can reroll the die and must use the new roll.',
                    'Brave' => 'You have advantage on saving throws against being frightened.',
                    'Halfling Nimbleness' => 'You can move through the space of any creature that is of a size larger than yours.',
                ],
            ],
            [
                'name' => 'Dragonborn',
                'description' => 'Born of dragons, as their name proclaims, the dragonborn walk proudly through a world that greets them with fearful incomprehension.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'strength' => 2,
                    'charisma' => 1,
                ],
                'languages' => ['Common', 'Draconic'],
                'traits' => [
                    'Draconic Ancestry' => 'You have draconic ancestry. Choose one type of dragon from the Draconic Ancestry table. Your breath weapon and damage resistance are determined by the dragon type.',
                    'Breath Weapon' => 'You can use your action to exhale destructive energy. Your draconic ancestry determines the size, shape, and damage type of the exhalation.',
                    'Damage Resistance' => 'You have resistance to the damage type associated with your draconic ancestry.',
                ],
            ],
            [
                'name' => 'Gnome',
                'description' => 'A gnome\'s energy and enthusiasm for living shines through every inch of his or her tiny body.',
                'size' => 'Small',
                'speed' => 25,
                'ability_score_increases' => [
                    'intelligence' => 2,
                ],
                'languages' => ['Common', 'Gnomish'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Gnome Cunning' => 'You have advantage on all Intelligence, Wisdom, and Charisma saving throws against magic.',
                ],
            ],
            [
                'name' => 'Half-Elf',
                'description' => 'Walking in two worlds but truly belonging to neither, half-elves combine what some say are the best qualities of their elf and human parents.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'charisma' => 2,
                    'type' => 'choice',
                    'choices' => 2,
                    'amount' => 1,
                ],
                'languages' => ['Common', 'Elvish', 'one_extra'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Fey Ancestry' => 'You have advantage on saving throws against being charmed, and magic can\'t put you to sleep.',
                    'Skill Versatility' => 'You gain proficiency in two skills of your choice.',
                ],
            ],
            [
                'name' => 'Half-Orc',
                'description' => 'Whether united under the leadership of a mighty warlock or having fought to a standstill after years of conflict, orc and human tribes sometimes form alliances, joining forces into a larger horde to the terror of civilized lands nearby.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'strength' => 2,
                    'constitution' => 1,
                ],
                'languages' => ['Common', 'Orc'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Menacing' => 'You gain proficiency in the Intimidation skill.',
                    'Relentless Endurance' => 'When you are reduced to 0 hit points but not killed outright, you can drop to 1 hit point instead. You can\'t use this feature again until you finish a long rest.',
                    'Savage Attacks' => 'When you score a critical hit with a melee weapon attack, you can roll one of the weapon\'s damage dice one additional time and add it to the extra damage of the critical hit.',
                ],
            ],
            [
                'name' => 'Tiefling',
                'description' => 'To be greeted with stares and whispers, to suffer violence and insult on the street, to see mistrust and fear in every eye: this is the lot of the tiefling.',
                'size' => 'Medium',
                'speed' => 30,
                'ability_score_increases' => [
                    'charisma' => 2,
                    'intelligence' => 1,
                ],
                'languages' => ['Common', 'Infernal'],
                'traits' => [
                    'Darkvision' => 'You can see in dim light within 60 feet of you as if it were bright light, and in darkness as if it were dim light.',
                    'Hellish Resistance' => 'You have resistance to fire damage.',
                    'Infernal Legacy' => 'You know the thaumaturgy cantrip. When you reach 3rd level, you can cast the hellish rebuke spell as a 2nd-level spell once with this trait and regain the ability to do so when you finish a long rest.',
                ],
            ],
        ];
    }
}
