<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CharacterClass;
use App\Models\ClassFeature;
use App\Models\Subclass;
use Illuminate\Database\Seeder;

final class ClassFeatureSeeder extends Seeder
{
    /**
     * @var array<array{class_slug: string, subclass_slug: string|null, name: string, description: string, level: int}>
     */
    private array $features = [
        // Barbarian Class Features
        ['class_slug' => 'barbarian', 'subclass_slug' => null, 'name' => 'Rage', 'description' => 'In battle, you fight with primal ferocity. On your turn, you can enter a rage as a bonus action.', 'level' => 1],
        ['class_slug' => 'barbarian', 'subclass_slug' => null, 'name' => 'Unarmored Defense', 'description' => 'While you are not wearing any armor, your AC equals 10 + your Dexterity modifier + your Constitution modifier.', 'level' => 1],
        ['class_slug' => 'barbarian', 'subclass_slug' => null, 'name' => 'Reckless Attack', 'description' => 'You can throw aside all concern for defense to attack with fierce desperation.', 'level' => 2],
        ['class_slug' => 'barbarian', 'subclass_slug' => null, 'name' => 'Danger Sense', 'description' => 'You have advantage on Dexterity saving throws against effects that you can see.', 'level' => 2],
        ['class_slug' => 'barbarian', 'subclass_slug' => null, 'name' => 'Extra Attack', 'description' => 'You can attack twice, instead of once, whenever you take the Attack action on your turn.', 'level' => 5],

        // Bard Class Features
        ['class_slug' => 'bard', 'subclass_slug' => null, 'name' => 'Bardic Inspiration', 'description' => 'You can inspire others through stirring words or music. A creature can roll the die and add the number rolled to one ability check, attack roll, or saving throw.', 'level' => 1],
        ['class_slug' => 'bard', 'subclass_slug' => null, 'name' => 'Spellcasting', 'description' => 'You have learned to untangle and reshape the fabric of reality in harmony with your wishes and music.', 'level' => 1],
        ['class_slug' => 'bard', 'subclass_slug' => null, 'name' => 'Jack of All Trades', 'description' => 'You can add half your proficiency bonus, rounded down, to any ability check you make that doesn\'t already include your proficiency bonus.', 'level' => 2],
        ['class_slug' => 'bard', 'subclass_slug' => null, 'name' => 'Song of Rest', 'description' => 'You can use soothing music or oration to help revitalize your wounded allies during a short rest.', 'level' => 2],
        ['class_slug' => 'bard', 'subclass_slug' => null, 'name' => 'Expertise', 'description' => 'Choose two of your skill proficiencies. Your proficiency bonus is doubled for any ability check you make that uses either of the chosen proficiencies.', 'level' => 3],

        // Cleric Class Features
        ['class_slug' => 'cleric', 'subclass_slug' => null, 'name' => 'Spellcasting', 'description' => 'As a conduit for divine power, you can cast cleric spells.', 'level' => 1],
        ['class_slug' => 'cleric', 'subclass_slug' => null, 'name' => 'Divine Domain', 'description' => 'Choose one domain related to your deity. Your domain grants you features at 1st level and again at later levels.', 'level' => 1],
        ['class_slug' => 'cleric', 'subclass_slug' => null, 'name' => 'Channel Divinity', 'description' => 'You gain the ability to channel divine energy directly from your deity.', 'level' => 2],
        ['class_slug' => 'cleric', 'subclass_slug' => null, 'name' => 'Turn Undead', 'description' => 'As an action, you present your holy symbol and speak a prayer censuring the undead.', 'level' => 2],

        // Fighter Class Features
        ['class_slug' => 'fighter', 'subclass_slug' => null, 'name' => 'Fighting Style', 'description' => 'You adopt a particular style of fighting as your specialty.', 'level' => 1],
        ['class_slug' => 'fighter', 'subclass_slug' => null, 'name' => 'Second Wind', 'description' => 'You have a limited well of stamina that you can draw on to protect yourself from harm.', 'level' => 1],
        ['class_slug' => 'fighter', 'subclass_slug' => null, 'name' => 'Action Surge', 'description' => 'You can push yourself beyond your normal limits for a moment.', 'level' => 2],
        ['class_slug' => 'fighter', 'subclass_slug' => null, 'name' => 'Extra Attack', 'description' => 'You can attack twice, instead of once, whenever you take the Attack action on your turn.', 'level' => 5],
        ['class_slug' => 'fighter', 'subclass_slug' => null, 'name' => 'Indomitable', 'description' => 'You can reroll a saving throw that you fail.', 'level' => 9],

        // Rogue Class Features
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Expertise', 'description' => 'Choose two of your skill proficiencies or your proficiency with thieves\' tools. Your proficiency bonus is doubled for any ability check you make that uses either of the chosen proficiencies.', 'level' => 1],
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Sneak Attack', 'description' => 'You know how to strike subtly and exploit a foe\'s distraction.', 'level' => 1],
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Thieves\' Cant', 'description' => 'During your rogue training you learned thieves\' cant, a secret mix of dialect, jargon, and code.', 'level' => 1],
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Cunning Action', 'description' => 'Your quick thinking and agility allow you to move and act quickly.', 'level' => 2],
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Uncanny Dodge', 'description' => 'When an attacker that you can see hits you with an attack, you can use your reaction to halve the attack\'s damage against you.', 'level' => 5],
        ['class_slug' => 'rogue', 'subclass_slug' => null, 'name' => 'Evasion', 'description' => 'When you are subjected to an effect that allows you to make a Dexterity saving throw to take only half damage, you instead take no damage if you succeed.', 'level' => 7],

        // Wizard Class Features
        ['class_slug' => 'wizard', 'subclass_slug' => null, 'name' => 'Spellcasting', 'description' => 'As a student of arcane magic, you have a spellbook containing spells that show the first glimmerings of your true power.', 'level' => 1],
        ['class_slug' => 'wizard', 'subclass_slug' => null, 'name' => 'Arcane Recovery', 'description' => 'You have learned to regain some of your magical energy by studying your spellbook.', 'level' => 1],
        ['class_slug' => 'wizard', 'subclass_slug' => null, 'name' => 'Spell Mastery', 'description' => 'You have achieved such mastery over certain spells that you can cast them at will.', 'level' => 18],

        // Fighter Subclass Features - Champion
        ['class_slug' => 'fighter', 'subclass_slug' => 'champion', 'name' => 'Improved Critical', 'description' => 'Your weapon attacks score a critical hit on a roll of 19 or 20.', 'level' => 3],
        ['class_slug' => 'fighter', 'subclass_slug' => 'champion', 'name' => 'Remarkable Athlete', 'description' => 'You can add half your proficiency bonus to any Strength, Dexterity, or Constitution check you make that doesn\'t already use your proficiency bonus.', 'level' => 7],
        ['class_slug' => 'fighter', 'subclass_slug' => 'champion', 'name' => 'Superior Critical', 'description' => 'Your weapon attacks score a critical hit on a roll of 18-20.', 'level' => 15],

        // Fighter Subclass Features - Battle Master
        ['class_slug' => 'fighter', 'subclass_slug' => 'battle-master', 'name' => 'Combat Superiority', 'description' => 'You learn maneuvers that are fueled by special dice called superiority dice.', 'level' => 3],
        ['class_slug' => 'fighter', 'subclass_slug' => 'battle-master', 'name' => 'Student of War', 'description' => 'You gain proficiency with one type of artisan\'s tools of your choice.', 'level' => 3],
        ['class_slug' => 'fighter', 'subclass_slug' => 'battle-master', 'name' => 'Know Your Enemy', 'description' => 'If you spend at least 1 minute observing or interacting with another creature outside combat, you can learn certain information about its capabilities.', 'level' => 7],

        // Cleric Subclass Features - Life Domain
        ['class_slug' => 'cleric', 'subclass_slug' => 'life-domain', 'name' => 'Disciple of Life', 'description' => 'Your healing spells are more effective. Whenever you use a spell of 1st level or higher to restore hit points, the creature regains additional hit points.', 'level' => 1],
        ['class_slug' => 'cleric', 'subclass_slug' => 'life-domain', 'name' => 'Preserve Life', 'description' => 'You can use your Channel Divinity to heal the badly injured.', 'level' => 2],
        ['class_slug' => 'cleric', 'subclass_slug' => 'life-domain', 'name' => 'Blessed Healer', 'description' => 'The healing spells you cast on others heal you as well.', 'level' => 6],

        // Wizard Subclass Features - School of Evocation
        ['class_slug' => 'wizard', 'subclass_slug' => 'school-of-evocation', 'name' => 'Evocation Savant', 'description' => 'The gold and time you must spend to copy an evocation spell into your spellbook is halved.', 'level' => 2],
        ['class_slug' => 'wizard', 'subclass_slug' => 'school-of-evocation', 'name' => 'Sculpt Spells', 'description' => 'You can create pockets of relative safety within the effects of your evocation spells.', 'level' => 2],
        ['class_slug' => 'wizard', 'subclass_slug' => 'school-of-evocation', 'name' => 'Potent Cantrip', 'description' => 'Your damaging cantrips affect even creatures that avoid the brunt of the effect.', 'level' => 6],
        ['class_slug' => 'wizard', 'subclass_slug' => 'school-of-evocation', 'name' => 'Empowered Evocation', 'description' => 'You can add your Intelligence modifier to one damage roll of any wizard evocation spell you cast.', 'level' => 10],
    ];

    public function run(): void
    {
        foreach ($this->features as $featureData) {
            $classSlug    = $featureData['class_slug'];
            $subclassSlug = $featureData['subclass_slug'];
            unset($featureData['class_slug'], $featureData['subclass_slug']);

            $class    = CharacterClass::where('slug', $classSlug)->first();
            $subclass = $subclassSlug !== null ? Subclass::where('slug', $subclassSlug)->first() : null;

            if ($class !== null) {
                ClassFeature::updateOrCreate(
                    [
                        'class_id' => $class->id,
                        'name'     => $featureData['name'],
                        'level'    => $featureData['level'],
                    ],
                    array_merge($featureData, [
                        'class_id'            => $class->id,
                        'subclass_id'         => $subclass?->id,
                        'is_subclass_feature' => $subclass !== null,
                    ])
                );
            }
        }
    }
}
