<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

final class SkillSeeder extends Seeder
{
    /**
     * @var array<array{name: string, slug: string, ability: string, description: string}>
     */
    private array $skills = [
        // Strength Skills
        [
            'name'        => 'Athletics',
            'slug'        => 'athletics',
            'ability'     => 'strength',
            'description' => 'Covers difficult physical situations: climbing, jumping, swimming, grappling.',
        ],
        // Dexterity Skills
        [
            'name'        => 'Acrobatics',
            'slug'        => 'acrobatics',
            'ability'     => 'dexterity',
            'description' => 'Covers attempts to stay on your feet in tricky situations, stunts, and balance.',
        ],
        [
            'name'        => 'Sleight of Hand',
            'slug'        => 'sleight-of-hand',
            'ability'     => 'dexterity',
            'description' => 'Covers manual trickery and fine motor control.',
        ],
        [
            'name'        => 'Stealth',
            'slug'        => 'stealth',
            'ability'     => 'dexterity',
            'description' => 'Covers attempts to hide and move quietly.',
        ],
        // Intelligence Skills
        [
            'name'        => 'Arcana',
            'slug'        => 'arcana',
            'ability'     => 'intelligence',
            'description' => 'Measures recall of lore about spells, magic items, planes, and magical creatures.',
        ],
        [
            'name'        => 'History',
            'slug'        => 'history',
            'ability'     => 'intelligence',
            'description' => 'Measures recall of lore about historical events, people, kingdoms, and conflicts.',
        ],
        [
            'name'        => 'Investigation',
            'slug'        => 'investigation',
            'ability'     => 'intelligence',
            'description' => 'Covers deduction, searching for clues, and gathering information.',
        ],
        [
            'name'        => 'Nature',
            'slug'        => 'nature',
            'ability'     => 'intelligence',
            'description' => 'Measures recall of lore about terrain, plants, animals, and weather.',
        ],
        [
            'name'        => 'Religion',
            'slug'        => 'religion',
            'ability'     => 'intelligence',
            'description' => 'Measures recall of lore about deities, religious rites, prayers, and religious organizations.',
        ],
        // Wisdom Skills
        [
            'name'        => 'Animal Handling',
            'slug'        => 'animal-handling',
            'ability'     => 'wisdom',
            'description' => 'Covers calming animals, controlling mounts, and understanding animal behavior.',
        ],
        [
            'name'        => 'Insight',
            'slug'        => 'insight',
            'ability'     => 'wisdom',
            'description' => 'Covers determining true intentions, detecting lies, and reading body language.',
        ],
        [
            'name'        => 'Medicine',
            'slug'        => 'medicine',
            'ability'     => 'wisdom',
            'description' => 'Covers stabilizing the dying, diagnosing illness, and treating wounds.',
        ],
        [
            'name'        => 'Perception',
            'slug'        => 'perception',
            'ability'     => 'wisdom',
            'description' => 'Covers detecting presences, noticing details, and general awareness.',
        ],
        [
            'name'        => 'Survival',
            'slug'        => 'survival',
            'ability'     => 'wisdom',
            'description' => 'Covers tracking, hunting, navigating, and surviving in the wilderness.',
        ],
        // Charisma Skills
        [
            'name'        => 'Deception',
            'slug'        => 'deception',
            'ability'     => 'charisma',
            'description' => 'Covers hiding the truth through words or actions.',
        ],
        [
            'name'        => 'Intimidation',
            'slug'        => 'intimidation',
            'ability'     => 'charisma',
            'description' => 'Covers influencing through threats, hostile actions, or physical presence.',
        ],
        [
            'name'        => 'Performance',
            'slug'        => 'performance',
            'ability'     => 'charisma',
            'description' => 'Covers entertaining through music, dance, acting, or storytelling.',
        ],
        [
            'name'        => 'Persuasion',
            'slug'        => 'persuasion',
            'ability'     => 'charisma',
            'description' => 'Covers influencing through tact, social graces, or good nature.',
        ],
    ];

    public function run(): void
    {
        foreach ($this->skills as $skill) {
            Skill::updateOrCreate(
                ['slug' => $skill['slug']],
                $skill
            );
        }
    }
}
