<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Feat;
use Illuminate\Database\Seeder;

final class FeatSeeder extends Seeder
{
    public function run(): void
    {
        $feats = $this->getFeatData();

        foreach ($feats as $featData) {
            Feat::create($featData);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function getFeatData(): array
    {
        return [
            [
                'name' => 'Alert',
                'description' => 'Always on the lookout for danger, you gain the following benefits: You gain a +5 bonus to initiative. You can\'t be surprised while you are conscious. Other creatures don\'t gain advantage on attack rolls against you as a result of being unseen by you.',
                'prerequisites' => null,
                'benefits' => [
                    '+5 bonus to initiative',
                    'Can\'t be surprised while conscious',
                    'Hidden creatures don\'t gain advantage on attacks against you',
                ],
            ],
            [
                'name' => 'Athlete',
                'description' => 'You have undergone extensive physical training to gain the following benefits: Increase your Strength or Dexterity score by 1, to a maximum of 20. When you are prone, standing up uses only 5 feet of your movement. Climbing doesn\'t cost you extra movement. You can make a running long jump or a running high jump after moving only 5 feet on foot, rather than 10 feet.',
                'prerequisites' => null,
                'benefits' => [
                    'Increase Strength or Dexterity by 1',
                    'Standing up from prone uses only 5 feet of movement',
                    'Climbing doesn\'t cost extra movement',
                    'Running jump after only 5 feet of movement',
                ],
            ],
            [
                'name' => 'Dual Wielder',
                'description' => 'You master fighting with two weapons, gaining the following benefits: You gain a +1 bonus to AC while you are wielding a separate melee weapon in each hand. You can use two-weapon fighting even when the one-handed melee weapons you are wielding aren\'t light. You can draw or stow two one-handed weapons when you would normally be able to draw or stow only one.',
                'prerequisites' => null,
                'benefits' => [
                    '+1 bonus to AC while dual wielding',
                    'Can use two-weapon fighting with non-light weapons',
                    'Can draw or stow two weapons at once',
                ],
            ],
            [
                'name' => 'Durable',
                'description' => 'Hardy and resilient, you gain the following benefits: Increase your Constitution score by 1, to a maximum of 20. When you roll a Hit Die to regain hit points, the minimum number of hit points you regain from the roll equals twice your Constitution modifier (minimum of 2).',
                'prerequisites' => null,
                'benefits' => [
                    'Increase Constitution by 1',
                    'Minimum hit points from Hit Die equals twice Constitution modifier',
                ],
            ],
            [
                'name' => 'Great Weapon Master',
                'description' => 'You\'ve learned to put the weight of a weapon to your advantage, letting its momentum empower your strikes. You gain the following benefits: On your turn, when you score a critical hit with a melee weapon or reduce a creature to 0 hit points with one, you can make one melee weapon attack as a bonus action. Before you make a melee attack with a heavy weapon that you are proficient with, you can choose to take a -5 penalty to the attack roll. If the attack hits, you add +10 to the attack\'s damage.',
                'prerequisites' => null,
                'benefits' => [
                    'Bonus action attack after critical hit or reducing creature to 0 HP',
                    'Can take -5 to attack roll for +10 damage with heavy weapons',
                ],
            ],
            [
                'name' => 'Lucky',
                'description' => 'You have inexplicable luck that seems to kick in at just the right moment. You have 3 luck points. Whenever you make an attack roll, an ability check, or a saving throw, you can spend one luck point to roll an additional d20. You can choose to spend one of your luck points after you roll the die, but before the outcome is determined. You choose which of the d20s is used for the attack roll, ability check, or saving throw. You regain your expended luck points when you finish a long rest.',
                'prerequisites' => null,
                'benefits' => [
                    'Gain 3 luck points',
                    'Spend a luck point to roll an additional d20',
                    'Choose which d20 to use for the roll',
                    'Regain luck points on long rest',
                ],
            ],
            [
                'name' => 'Magic Initiate',
                'description' => 'Choose a class: bard, cleric, druid, sorcerer, warlock, or wizard. You learn two cantrips of your choice from that class\'s spell list. In addition, choose one 1st-level spell from that same list. You learn that spell and can cast it at its lowest level. Once you cast it, you must finish a long rest before you can cast it again. Your spellcasting ability for these spells depends on the class you chose: Charisma for bard, sorcerer, or warlock; Wisdom for cleric or druid; or Intelligence for wizard.',
                'prerequisites' => null,
                'benefits' => [
                    'Learn 2 cantrips from chosen class',
                    'Learn 1 first-level spell from chosen class',
                    'Cast the spell once per long rest',
                ],
            ],
            [
                'name' => 'Resilient',
                'description' => 'Choose one ability score. You gain the following benefits: Increase the chosen ability score by 1, to a maximum of 20. You gain proficiency in saving throws using the chosen ability.',
                'prerequisites' => null,
                'benefits' => [
                    'Increase one ability score by 1',
                    'Gain proficiency in saving throws using that ability',
                ],
            ],
            [
                'name' => 'Sentinel',
                'description' => 'You have mastered techniques to take advantage of every drop in any enemy\'s guard, gaining the following benefits: When you hit a creature with an opportunity attack, the creature\'s speed becomes 0 for the rest of the turn. Creatures provoke opportunity attacks from you even if they take the Disengage action before leaving your reach. When a creature within 5 feet of you makes an attack against a target other than you, you can use your reaction to make a melee weapon attack against the attacking creature.',
                'prerequisites' => null,
                'benefits' => [
                    'Opportunity attacks reduce target\'s speed to 0',
                    'Creatures provoke opportunity attacks even when Disengaging',
                    'Reaction attack when adjacent creature attacks someone else',
                ],
            ],
            [
                'name' => 'Sharpshooter',
                'description' => 'You have mastered ranged weapons and can make shots that others find impossible. You gain the following benefits: Attacking at long range doesn\'t impose disadvantage on your ranged weapon attack rolls. Your ranged weapon attacks ignore half cover and three-quarters cover. Before you make an attack with a ranged weapon that you are proficient with, you can choose to take a -5 penalty to the attack roll. If the attack hits, you add +10 to the attack\'s damage.',
                'prerequisites' => null,
                'benefits' => [
                    'No disadvantage on long range attacks',
                    'Ranged attacks ignore half and three-quarters cover',
                    'Can take -5 to attack roll for +10 damage',
                ],
            ],
            [
                'name' => 'Tough',
                'description' => 'Your hit point maximum increases by an amount equal to twice your level when you gain this feat. Whenever you gain a level thereafter, your hit point maximum increases by an additional 2 hit points.',
                'prerequisites' => null,
                'benefits' => [
                    'Hit point maximum increases by 2 per level',
                ],
            ],
            [
                'name' => 'War Caster',
                'description' => 'You have practiced casting spells in the midst of combat, learning techniques that grant you the following benefits: You have advantage on Constitution saving throws that you make to maintain your concentration on a spell when you take damage. You can perform the somatic components of spells even when you have weapons or a shield in one or both hands. When a hostile creature\'s movement provokes an opportunity attack from you, you can use your reaction to cast a spell at the creature, rather than making an opportunity attack. The spell must have a casting time of 1 action and must target only that creature.',
                'prerequisites' => null,
                'benefits' => [
                    'Advantage on concentration saving throws',
                    'Can perform somatic components with weapons or shield',
                    'Can cast a spell instead of making opportunity attack',
                ],
            ],
        ];
    }
}
