<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;

final class SpeciesSeeder extends Seeder
{
    /**
     * @var array<array<string, mixed>>
     */
    private array $species = [
        [
            'name'          => 'Aasimar',
            'slug'          => 'aasimar',
            'description'   => 'Blessed with celestial heritage, aasimar are champions of good.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 60,
            'traits'        => [
                ['name' => 'Celestial Resistance', 'description' => 'You have resistance to Necrotic and Radiant damage.'],
                ['name' => 'Healing Hands', 'description' => 'As an action, touch a creature to heal HP equal to your proficiency bonus once per long rest.'],
                ['name' => 'Light Bearer', 'description' => 'You know the Light cantrip. Charisma is your spellcasting ability.'],
                ['name' => 'Celestial Revelation', 'description' => 'Starting at 3rd level, choose one revelation once per long rest.'],
            ],
            'languages'             => ['Common', 'Celestial'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ],
        [
            'name'          => 'Dragonborn',
            'slug'          => 'dragonborn',
            'description'   => 'Dragonborn carry the legacy of dragons in their blood.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 60,
            'traits'        => [
                ['name' => 'Draconic Ancestry', 'description' => 'Choose a dragon type; determines damage type for breath weapon and resistance.'],
                ['name' => 'Breath Weapon', 'description' => 'Exhale destructive energy; usable proficiency bonus times per long rest.'],
                ['name' => 'Damage Resistance', 'description' => 'Resistance to damage type from ancestry.'],
            ],
            'languages'             => ['Common', 'Draconic'],
            'ability_score_options' => null,
            'has_lineage_choice'    => true,
            'lineages'              => [
                ['name' => 'Black', 'damage_type' => 'Acid', 'breath_shape' => '30 ft line'],
                ['name' => 'Blue', 'damage_type' => 'Lightning', 'breath_shape' => '30 ft line'],
                ['name' => 'Brass', 'damage_type' => 'Fire', 'breath_shape' => '30 ft line'],
                ['name' => 'Bronze', 'damage_type' => 'Lightning', 'breath_shape' => '30 ft line'],
                ['name' => 'Copper', 'damage_type' => 'Acid', 'breath_shape' => '30 ft line'],
                ['name' => 'Gold', 'damage_type' => 'Fire', 'breath_shape' => '15 ft cone'],
                ['name' => 'Green', 'damage_type' => 'Poison', 'breath_shape' => '15 ft cone'],
                ['name' => 'Red', 'damage_type' => 'Fire', 'breath_shape' => '15 ft cone'],
                ['name' => 'Silver', 'damage_type' => 'Cold', 'breath_shape' => '15 ft cone'],
                ['name' => 'White', 'damage_type' => 'Cold', 'breath_shape' => '15 ft cone'],
            ],
        ],
        [
            'name'          => 'Dwarf',
            'slug'          => 'dwarf',
            'description'   => 'Dwarves are sturdy folk known for their craftsmanship and resilience.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 120,
            'traits'        => [
                ['name' => 'Dwarven Resilience', 'description' => 'Resistance to Poison damage; advantage on saves vs. poisoned.'],
                ['name' => 'Dwarven Toughness', 'description' => 'HP maximum increases by 1 per level.'],
                ['name' => 'Stonecunning', 'description' => 'As a bonus action, gain tremorsense 60 ft for 10 minutes.'],
            ],
            'languages'             => ['Common', 'Dwarvish'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ],
        [
            'name'          => 'Elf',
            'slug'          => 'elf',
            'description'   => 'Elves are graceful beings with long lifespans and magical heritage.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 60,
            'traits'        => [
                ['name' => 'Fey Ancestry', 'description' => 'Advantage on saves vs. charmed; magic can\'t put you to sleep.'],
                ['name' => 'Keen Senses', 'description' => 'Proficiency in Perception.'],
                ['name' => 'Trance', 'description' => '4 hours of trance replaces 8 hours of sleep.'],
            ],
            'languages'             => ['Common', 'Elvish'],
            'ability_score_options' => null,
            'has_lineage_choice'    => true,
            'lineages'              => [
                ['name' => 'Drow', 'description' => '120 ft darkvision; Dancing Lights cantrip; at 3rd: Faerie Fire; at 5th: Darkness.'],
                ['name' => 'High Elf', 'description' => 'One Wizard cantrip; learn one extra language.'],
                ['name' => 'Wood Elf', 'description' => 'Speed 35 ft; proficiency in Stealth; hide when lightly obscured by nature.'],
            ],
        ],
        [
            'name'          => 'Gnome',
            'slug'          => 'gnome',
            'description'   => 'Gnomes are small, curious folk with a talent for magic and invention.',
            'size'          => 'Small',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 60,
            'traits'        => [
                ['name' => 'Gnomish Cunning', 'description' => 'Advantage on INT, WIS, and CHA saves against magic.'],
            ],
            'languages'             => ['Common', 'Gnomish'],
            'ability_score_options' => null,
            'has_lineage_choice'    => true,
            'lineages'              => [
                ['name' => 'Forest Gnome', 'description' => 'Minor Illusion cantrip; speak with Small or smaller beasts.'],
                ['name' => 'Rock Gnome', 'description' => 'Mending and Prestidigitation cantrips; tinker ability.'],
            ],
        ],
        [
            'name'          => 'Goliath',
            'slug'          => 'goliath',
            'description'   => 'Goliaths are towering, competitive people from mountain peaks.',
            'size'          => 'Medium',
            'speed'         => 35,
            'creature_type' => 'Humanoid',
            'darkvision'    => null,
            'traits'        => [
                ['name' => 'Large Form', 'description' => 'Advantage on STR saving throws; count as Large for pushing, pulling, and lifting.'],
                ['name' => 'Powerful Build', 'description' => 'Count as Large for carrying capacity.'],
            ],
            'languages'             => ['Common', 'Giant'],
            'ability_score_options' => null,
            'has_lineage_choice'    => true,
            'lineages'              => [
                ['name' => 'Cloud', 'description' => 'As a reaction when hit, reduce damage by 1d10 + CON modifier.'],
                ['name' => 'Fire', 'description' => 'When you hit with an attack, add 1d10 fire damage.'],
                ['name' => 'Frost', 'description' => 'When you hit with an attack, add 1d6 cold damage and reduce target\'s speed by 10 ft.'],
                ['name' => 'Hill', 'description' => 'When you take damage, roll 1d12 + CON modifier; if equals or exceeds damage, take no damage.'],
                ['name' => 'Stone', 'description' => 'When you hit with an attack, add 1d6 force damage; push Large or smaller target 10 ft.'],
                ['name' => 'Storm', 'description' => 'As a reaction when hit within 60 ft, deal lightning damage equal to proficiency bonus.'],
            ],
        ],
        [
            'name'          => 'Halfling',
            'slug'          => 'halfling',
            'description'   => 'Halflings are small, nimble folk known for their luck and resourcefulness.',
            'size'          => 'Small',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => null,
            'traits'        => [
                ['name' => 'Brave', 'description' => 'Advantage on saves vs. frightened.'],
                ['name' => 'Halfling Nimbleness', 'description' => 'Move through space of Medium+ creatures.'],
                ['name' => 'Luck', 'description' => 'When you roll a 1 on d20, reroll and use new result.'],
                ['name' => 'Naturally Stealthy', 'description' => 'Can attempt to hide behind Medium+ creatures.'],
            ],
            'languages'             => ['Common', 'Halfling'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ],
        [
            'name'          => 'Human',
            'slug'          => 'human',
            'description'   => 'Humans are the most versatile and adaptable species.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => null,
            'traits'        => [
                ['name' => 'Resourceful', 'description' => 'Gain Heroic Inspiration when you finish a long rest.'],
                ['name' => 'Skillful', 'description' => 'Proficiency in one skill of your choice.'],
                ['name' => 'Versatile', 'description' => 'Choose one Origin feat for which you qualify.'],
            ],
            'languages'             => ['Common'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ],
        [
            'name'          => 'Orc',
            'slug'          => 'orc',
            'description'   => 'Orcs are powerful warriors with a strong connection to their ancestors.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 120,
            'traits'        => [
                ['name' => 'Adrenaline Rush', 'description' => 'Take Dash as bonus action; gain temp HP equal to proficiency bonus.'],
                ['name' => 'Relentless Endurance', 'description' => 'When reduced to 0 HP but not killed, drop to 1 HP instead once per long rest.'],
            ],
            'languages'             => ['Common', 'Orc'],
            'ability_score_options' => null,
            'has_lineage_choice'    => false,
            'lineages'              => null,
        ],
        [
            'name'          => 'Tiefling',
            'slug'          => 'tiefling',
            'description'   => 'Tieflings bear the mark of infernal heritage.',
            'size'          => 'Medium',
            'speed'         => 30,
            'creature_type' => 'Humanoid',
            'darkvision'    => 60,
            'traits'        => [
                ['name' => 'Otherworldly Presence', 'description' => 'You know the Thaumaturgy cantrip.'],
            ],
            'languages'             => ['Common', 'Infernal'],
            'ability_score_options' => null,
            'has_lineage_choice'    => true,
            'lineages'              => [
                ['name' => 'Abyssal', 'description' => 'Poison Spray at 3rd, Ray of Sickness at 5th. Poison resistance.'],
                ['name' => 'Chthonic', 'description' => 'False Life at 3rd, Ray of Enfeeblement at 5th. Necrotic resistance.'],
                ['name' => 'Infernal', 'description' => 'Hellish Rebuke at 3rd, Darkness at 5th. Fire resistance.'],
            ],
        ],
    ];

    public function run(): void
    {
        foreach ($this->species as $speciesData) {
            Species::updateOrCreate(
                ['slug' => $speciesData['slug']],
                $speciesData
            );
        }
    }
}
