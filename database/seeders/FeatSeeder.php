<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Feat;
use Illuminate\Database\Seeder;

final class FeatSeeder extends Seeder
{
    /**
     * @var array<array{name: string, slug: string, description: string, category: string, prerequisites: array<string, mixed>|null, benefits: array<string>, repeatable: bool}>
     */
    private array $feats = [
        // Origin Feats
        [
            'name'          => 'Alert',
            'slug'          => 'alert',
            'description'   => 'Always on the lookout for danger, you gain exceptional awareness.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain a +5 bonus to initiative.',
                'You can\'t be surprised while you are conscious.',
                'Other creatures don\'t gain advantage on attack rolls against you as a result of being unseen by you.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Crafter',
            'slug'          => 'crafter',
            'description'   => 'You are adept at crafting items.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain proficiency with three tools of your choice.',
                'You can craft items at a faster rate.',
                'When you craft an item, you can use your proficiency bonus for any relevant ability checks.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Healer',
            'slug'          => 'healer',
            'description'   => 'You are an able physician, allowing you to mend wounds quickly.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain proficiency with Healer\'s Kit.',
                'As an action, you can spend one use of a healer\'s kit to tend to a creature and restore 1d6 + 4 hit points plus additional hit points equal to the creature\'s maximum number of Hit Dice.',
                'The creature can\'t regain hit points from this feat again until it finishes a short or long rest.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Lucky',
            'slug'          => 'lucky',
            'description'   => 'You have inexplicable luck that seems to kick in at just the right moment.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You have 3 luck points.',
                'Whenever you make an attack roll, ability check, or saving throw, you can spend one luck point to roll an additional d20.',
                'You can choose to spend luck points after you roll but before the outcome is determined.',
                'You regain all expended luck points when you finish a long rest.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Magic Initiate (Cleric)',
            'slug'          => 'magic-initiate-cleric',
            'description'   => 'You have learned the basics of divine magic.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You learn two cantrips of your choice from the Cleric spell list.',
                'You learn one 1st-level spell from the Cleric spell list.',
                'You can cast the 1st-level spell once without expending a spell slot, and regain the ability to do so after a long rest.',
                'Wisdom is your spellcasting ability for these spells.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Magic Initiate (Druid)',
            'slug'          => 'magic-initiate-druid',
            'description'   => 'You have learned the basics of nature magic.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You learn two cantrips of your choice from the Druid spell list.',
                'You learn one 1st-level spell from the Druid spell list.',
                'You can cast the 1st-level spell once without expending a spell slot, and regain the ability to do so after a long rest.',
                'Wisdom is your spellcasting ability for these spells.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Magic Initiate (Wizard)',
            'slug'          => 'magic-initiate-wizard',
            'description'   => 'You have learned the basics of arcane magic.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You learn two cantrips of your choice from the Wizard spell list.',
                'You learn one 1st-level spell from the Wizard spell list.',
                'You can cast the 1st-level spell once without expending a spell slot, and regain the ability to do so after a long rest.',
                'Intelligence is your spellcasting ability for these spells.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Musician',
            'slug'          => 'musician',
            'description'   => 'You are a practiced musician.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain proficiency with three musical instruments of your choice.',
                'As part of a short rest, you can play soothing music to help revitalize your allies.',
                'Any ally who hears your music regains an extra 1d6 hit points if they spend Hit Dice to regain hit points.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Savage Attacker',
            'slug'          => 'savage-attacker',
            'description'   => 'You strike with a brutality that few can match.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'Once per turn when you roll damage for a melee weapon attack, you can reroll the weapon\'s damage dice and use either total.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Skilled',
            'slug'          => 'skilled',
            'description'   => 'You have exceptional skill training.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'You gain proficiency in any combination of three skills or tools of your choice.',
            ],
            'repeatable' => true,
        ],
        [
            'name'          => 'Tavern Brawler',
            'slug'          => 'tavern-brawler',
            'description'   => 'Accustomed to rough-and-tumble fighting using whatever weapons happen to be at hand.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'Your unarmed strike uses a d4 for damage.',
                'You are proficient with improvised weapons.',
                'When you hit a creature with an unarmed strike or improvised weapon on your turn, you can use a bonus action to attempt to grapple the target.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Tough',
            'slug'          => 'tough',
            'description'   => 'Your health improves tremendously.',
            'category'      => 'origin',
            'prerequisites' => null,
            'benefits'      => [
                'Your hit point maximum increases by an amount equal to twice your level when you gain this feat.',
                'Whenever you gain a level thereafter, your hit point maximum increases by an additional 2 hit points.',
            ],
            'repeatable' => false,
        ],
        // General Feats (4th level)
        [
            'name'          => 'Great Weapon Master',
            'slug'          => 'great-weapon-master',
            'description'   => 'You\'ve learned to put the weight of a weapon to your advantage.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
            'benefits'      => [
                'On your turn, when you score a critical hit or reduce a creature to 0 hit points with a melee weapon, you can make one melee weapon attack as a bonus action.',
                'Before you make a melee attack with a heavy weapon, you can choose to take a -5 penalty to the attack roll. If the attack hits, you add +10 to the damage.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Sharpshooter',
            'slug'          => 'sharpshooter',
            'description'   => 'You have mastered ranged weapons.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
            'benefits'      => [
                'Attacking at long range doesn\'t impose disadvantage on your ranged weapon attack rolls.',
                'Your ranged weapon attacks ignore half cover and three-quarters cover.',
                'Before you make an attack with a ranged weapon, you can choose to take a -5 penalty to the attack roll. If the attack hits, you add +10 to the damage.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'War Caster',
            'slug'          => 'war-caster',
            'description'   => 'You have practiced casting spells in the midst of combat.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4, 'feature' => 'spellcasting'],
            'benefits'      => [
                'You have advantage on Constitution saving throws to maintain concentration on a spell.',
                'You can perform somatic components of spells even when you have weapons or a shield in one or both hands.',
                'When a hostile creature provokes an opportunity attack from you, you can cast a spell at the creature instead of making an opportunity attack.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Sentinel',
            'slug'          => 'sentinel',
            'description'   => 'You have mastered techniques to take advantage of every drop in any enemy\'s guard.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
            'benefits'      => [
                'When you hit a creature with an opportunity attack, the creature\'s speed becomes 0 for the rest of the turn.',
                'Creatures provoke opportunity attacks from you even if they take the Disengage action.',
                'When a creature within 5 feet of you makes an attack against a target other than you, you can use your reaction to make a melee weapon attack against the attacking creature.',
            ],
            'repeatable' => false,
        ],
        [
            'name'          => 'Resilient',
            'slug'          => 'resilient',
            'description'   => 'Choose one ability score. You gain proficiency in saving throws using that ability.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
            'benefits'      => [
                'Increase the chosen ability score by 1, to a maximum of 20.',
                'You gain proficiency in saving throws using the chosen ability.',
            ],
            'repeatable' => true,
        ],
        [
            'name'          => 'Mobile',
            'slug'          => 'mobile',
            'description'   => 'You are exceptionally speedy and agile.',
            'category'      => 'general',
            'prerequisites' => ['level' => 4],
            'benefits'      => [
                'Your speed increases by 10 feet.',
                'When you use the Dash action, difficult terrain doesn\'t cost you extra movement on that turn.',
                'When you make a melee attack against a creature, you don\'t provoke opportunity attacks from that creature for the rest of the turn, whether you hit or not.',
            ],
            'repeatable' => false,
        ],
    ];

    public function run(): void
    {
        foreach ($this->feats as $feat) {
            Feat::updateOrCreate(
                ['slug' => $feat['slug']],
                $feat
            );
        }
    }
}
