<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Background;
use Illuminate\Database\Seeder;

final class BackgroundSeeder extends Seeder
{
    public function run(): void
    {
        $backgrounds = $this->getBackgroundData();

        foreach ($backgrounds as $backgroundData) {
            Background::create($backgroundData);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getBackgroundData(): array
    {
        return [
            [
                'name' => 'Acolyte',
                'description' => 'You have spent your life in the service of a temple to a specific god or pantheon of gods. You act as an intermediary between the realm of the holy and the mortal world, performing sacred rites and offering sacrifices in order to conduct worshipers into the presence of the divine.',
                'skill_proficiencies' => ['insight', 'religion'],
                'tool_proficiencies' => null,
                'languages' => ['two_of_choice'],
                'starting_equipment' => ['holy_symbol', 'prayer_book', 'incense', 'vestments', 'common_clothes', '15_gp'],
                'feature_name' => 'Shelter of the Faithful',
                'feature_description' => 'As an acolyte, you command the respect of those who share your faith, and you can perform the religious ceremonies of your deity. You and your adventuring companions can expect to receive free healing and care at a temple, shrine, or other established presence of your faith.',
            ],
            [
                'name' => 'Charlatan',
                'description' => 'You have always had a way with people. You know what makes them tick, you can tease out their hearts\' desires after a few minutes of conversation, and with a few leading questions you can read them like they were children\'s books.',
                'skill_proficiencies' => ['deception', 'sleight_of_hand'],
                'tool_proficiencies' => ['disguise_kit', 'forgery_kit'],
                'languages' => null,
                'starting_equipment' => ['fine_clothes', 'disguise_kit', 'con_tools', '15_gp'],
                'feature_name' => 'False Identity',
                'feature_description' => 'You have created a second identity that includes documentation, established acquaintances, and disguises that allow you to assume that persona. Additionally, you can forge documents including official papers and personal letters.',
            ],
            [
                'name' => 'Criminal',
                'description' => 'You are an experienced criminal with a history of breaking the law. You have spent a lot of time among other criminals and still have contacts within the criminal underworld.',
                'skill_proficiencies' => ['deception', 'stealth'],
                'tool_proficiencies' => ['thieves_tools', 'one_type_gaming_set'],
                'languages' => null,
                'starting_equipment' => ['crowbar', 'dark_common_clothes', 'hood', '15_gp'],
                'feature_name' => 'Criminal Contact',
                'feature_description' => 'You have a reliable and trustworthy contact who acts as your liaison to a network of other criminals. You know how to get messages to and from your contact, even over great distances.',
            ],
            [
                'name' => 'Entertainer',
                'description' => 'You thrive in front of an audience. You know how to entrance them, entertain them, and even inspire them. Your poetics can stir the hearts of those who hear you, awakening grief or joy, laughter or anger.',
                'skill_proficiencies' => ['acrobatics', 'performance'],
                'tool_proficiencies' => ['disguise_kit', 'one_musical_instrument'],
                'languages' => null,
                'starting_equipment' => ['musical_instrument', 'favor_from_admirer', 'costume', '15_gp'],
                'feature_name' => 'By Popular Demand',
                'feature_description' => 'You can always find a place to perform, usually in an inn or tavern but possibly with a circus, at a theater, or even in a noble\'s court. At such a place, you receive free lodging and food of a modest or comfortable standard.',
            ],
            [
                'name' => 'Folk Hero',
                'description' => 'You come from a humble social rank, but you are destined for so much more. Already the people of your home village regard you as their champion, and your destiny calls you to stand against the tyrants and monsters that threaten the common folk everywhere.',
                'skill_proficiencies' => ['animal_handling', 'survival'],
                'tool_proficiencies' => ['one_artisan_tools', 'vehicles_land'],
                'languages' => null,
                'starting_equipment' => ['artisan_tools', 'shovel', 'iron_pot', 'common_clothes', '10_gp'],
                'feature_name' => 'Rustic Hospitality',
                'feature_description' => 'Since you come from the ranks of the common folk, you fit in among them with ease. You can find a place to hide, rest, or recuperate among other commoners, unless you have shown yourself to be a danger to them.',
            ],
            [
                'name' => 'Guild Artisan',
                'description' => 'You are a member of an artisan\'s guild, skilled in a particular field and closely associated with other artisans. You are a well-established part of the mercantile world, freed by talent and wealth from the constraints of a feudal social order.',
                'skill_proficiencies' => ['insight', 'persuasion'],
                'tool_proficiencies' => ['one_artisan_tools'],
                'languages' => ['one_of_choice'],
                'starting_equipment' => ['artisan_tools', 'letter_of_introduction', 'traveler_clothes', '15_gp'],
                'feature_name' => 'Guild Membership',
                'feature_description' => 'As an established and respected member of a guild, you can rely on certain benefits that membership provides. Your fellow guild members will provide you with lodging and food if necessary, and pay for your funeral if needed.',
            ],
            [
                'name' => 'Hermit',
                'description' => 'You lived in seclusion – either in a sheltered community such as a monastery, or entirely alone – for a formative part of your life. In your time apart from the clamor of society, you found quiet, solitude, and perhaps some of the answers you were looking for.',
                'skill_proficiencies' => ['medicine', 'religion'],
                'tool_proficiencies' => ['herbalism_kit'],
                'languages' => ['one_of_choice'],
                'starting_equipment' => ['scroll_case', 'winter_blanket', 'common_clothes', 'herbalism_kit', '5_gp'],
                'feature_name' => 'Discovery',
                'feature_description' => 'The quiet seclusion of your extended hermitage gave you access to a unique and powerful discovery. The exact nature of this revelation depends on the nature of your seclusion.',
            ],
            [
                'name' => 'Noble',
                'description' => 'You understand wealth, power, and privilege. You carry a noble title, and your family owns land, collects taxes, and wields significant political influence.',
                'skill_proficiencies' => ['history', 'persuasion'],
                'tool_proficiencies' => ['one_gaming_set'],
                'languages' => ['one_of_choice'],
                'starting_equipment' => ['fine_clothes', 'signet_ring', 'scroll_of_pedigree', '25_gp'],
                'feature_name' => 'Position of Privilege',
                'feature_description' => 'Thanks to your noble birth, people are inclined to think the best of you. You are welcome in high society, and people assume you have the right to be wherever you are.',
            ],
            [
                'name' => 'Outlander',
                'description' => 'You grew up in the wilds, far from civilization and the comforts of town and technology. You\'ve witnessed the migration of herds larger than forests, survived weather more extreme than any city-dweller could comprehend, and enjoyed the solitude of being the only thinking creature for miles in any direction.',
                'skill_proficiencies' => ['athletics', 'survival'],
                'tool_proficiencies' => ['one_musical_instrument'],
                'languages' => ['one_of_choice'],
                'starting_equipment' => ['staff', 'hunting_trap', 'trophy_from_animal', 'traveler_clothes', '10_gp'],
                'feature_name' => 'Wanderer',
                'feature_description' => 'You have an excellent memory for maps and geography, and you can always recall the general layout of terrain, settlements, and other features around you. In addition, you can find food and fresh water for yourself and up to five other people each day.',
            ],
            [
                'name' => 'Sage',
                'description' => 'You spent years learning the lore of the multiverse. You scoured manuscripts, studied scrolls, and listened to the greatest experts on the subjects that interest you. Your efforts have made you a master in your fields of study.',
                'skill_proficiencies' => ['arcana', 'history'],
                'tool_proficiencies' => null,
                'languages' => ['two_of_choice'],
                'starting_equipment' => ['ink', 'quill', 'small_knife', 'letter_from_colleague', 'common_clothes', '10_gp'],
                'feature_name' => 'Researcher',
                'feature_description' => 'When you attempt to learn or recall a piece of lore, if you do not know that information, you often know where and from whom you can obtain it. Usually, this information comes from a library, scriptorium, university, or a sage or other learned person or creature.',
            ],
            [
                'name' => 'Sailor',
                'description' => 'You sailed on a seagoing vessel for years. In that time, you faced down mighty storms, monsters of the deep, and those who wanted to sink your craft to the bottomless depths. Your first love is the distant line of the horizon, but the time has come to try your hand at something new.',
                'skill_proficiencies' => ['athletics', 'perception'],
                'tool_proficiencies' => ['navigator_tools', 'vehicles_water'],
                'languages' => null,
                'starting_equipment' => ['belaying_pin', 'silk_rope', 'lucky_charm', 'common_clothes', '10_gp'],
                'feature_name' => 'Ship\'s Passage',
                'feature_description' => 'When you need to, you can secure free passage on a sailing ship for yourself and your adventuring companions. You might sail on the ship you served on, or another ship you have good relations with.',
            ],
            [
                'name' => 'Soldier',
                'description' => 'War has been your life for as long as you care to remember. You trained as a youth, studied the use of weapons and armor, learned basic survival techniques, including how to stay alive on the battlefield.',
                'skill_proficiencies' => ['athletics', 'intimidation'],
                'tool_proficiencies' => ['one_gaming_set', 'vehicles_land'],
                'languages' => null,
                'starting_equipment' => ['rank_insignia', 'trophy_from_enemy', 'dice_or_cards', 'common_clothes', '10_gp'],
                'feature_name' => 'Military Rank',
                'feature_description' => 'You have a military rank from your career as a soldier. Soldiers loyal to your former military organization still recognize your authority and influence, and they defer to you if they are of a lower rank.',
            ],
            [
                'name' => 'Urchin',
                'description' => 'You grew up on the streets alone, orphaned, and poor. You had no one to watch over you or to provide for you, so you learned to provide for yourself. You fought fiercely over food and kept a constant watch out for other desperate souls who might steal from you.',
                'skill_proficiencies' => ['sleight_of_hand', 'stealth'],
                'tool_proficiencies' => ['disguise_kit', 'thieves_tools'],
                'languages' => null,
                'starting_equipment' => ['small_knife', 'map_of_city', 'pet_mouse', 'token_of_parents', 'common_clothes', '10_gp'],
                'feature_name' => 'City Secrets',
                'feature_description' => 'You know the secret patterns and flow of cities and can find passages through the urban sprawl that others would miss. When you are not in combat, you (and companions you lead) can travel between any two locations in the city twice as fast as your speed would normally allow.',
            ],
        ];
    }
}
