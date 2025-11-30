<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Background;
use App\Models\Feat;
use Illuminate\Database\Seeder;

final class BackgroundSeeder extends Seeder
{
    /**
     * @var array<array{name: string, slug: string, description: string, skill_proficiencies: array<string>, tool_proficiency: string, starting_equipment: array<array{item: string, quantity: int}>, starting_gold: float, origin_feat_slug: string}>
     */
    private array $backgrounds = [
        [
            'name'                => 'Acolyte',
            'slug'                => 'acolyte',
            'description'         => 'You devoted yourself to service in a temple.',
            'skill_proficiencies' => ['insight', 'religion'],
            'tool_proficiency'    => 'calligraphers-supplies',
            'starting_equipment'  => [
                ['item' => 'Calligrapher\'s Supplies', 'quantity' => 1],
                ['item' => 'Book (prayers)', 'quantity' => 1],
                ['item' => 'Holy Symbol', 'quantity' => 1],
                ['item' => 'Parchment', 'quantity' => 10],
                ['item' => 'Robe', 'quantity' => 1],
            ],
            'starting_gold'    => 3.00,
            'origin_feat_slug' => 'magic-initiate-cleric',
        ],
        [
            'name'                => 'Artisan',
            'slug'                => 'artisan',
            'description'         => 'You began mopping floors and scrubbing counters in an artisan\'s workshop.',
            'skill_proficiencies' => ['investigation', 'persuasion'],
            'tool_proficiency'    => 'artisans-tools',
            'starting_equipment'  => [
                ['item' => 'Artisan\'s Tools', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 32.00,
            'origin_feat_slug' => 'crafter',
        ],
        [
            'name'                => 'Charlatan',
            'slug'                => 'charlatan',
            'description'         => 'Once you were old enough to order an ale, you soon had a scheme to pay for it.',
            'skill_proficiencies' => ['deception', 'sleight-of-hand'],
            'tool_proficiency'    => 'forgery-kit',
            'starting_equipment'  => [
                ['item' => 'Forgery Kit', 'quantity' => 1],
                ['item' => 'Costume', 'quantity' => 1],
                ['item' => 'Fine Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 15.00,
            'origin_feat_slug' => 'skilled',
        ],
        [
            'name'                => 'Criminal',
            'slug'                => 'criminal',
            'description'         => 'You learned to earn your coin in dark alleyways, cutting purses or worse.',
            'skill_proficiencies' => ['sleight-of-hand', 'stealth'],
            'tool_proficiency'    => 'thieves-tools',
            'starting_equipment'  => [
                ['item' => 'Dagger', 'quantity' => 2],
                ['item' => 'Thieves\' Tools', 'quantity' => 1],
                ['item' => 'Crowbar', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 16.00,
            'origin_feat_slug' => 'alert',
        ],
        [
            'name'                => 'Entertainer',
            'slug'                => 'entertainer',
            'description'         => 'You spent much of your youth following roving fairs and carnivals.',
            'skill_proficiencies' => ['acrobatics', 'performance'],
            'tool_proficiency'    => 'musical-instrument',
            'starting_equipment'  => [
                ['item' => 'Musical Instrument', 'quantity' => 1],
                ['item' => 'Costume', 'quantity' => 2],
                ['item' => 'Mirror', 'quantity' => 1],
                ['item' => 'Perfume', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 11.00,
            'origin_feat_slug' => 'musician',
        ],
        [
            'name'                => 'Farmer',
            'slug'                => 'farmer',
            'description'         => 'You grew up close to the land, tending crops or animals.',
            'skill_proficiencies' => ['animal-handling', 'nature'],
            'tool_proficiency'    => 'carpenters-tools',
            'starting_equipment'  => [
                ['item' => 'Carpenter\'s Tools', 'quantity' => 1],
                ['item' => 'Healer\'s Kit', 'quantity' => 1],
                ['item' => 'Iron Pot', 'quantity' => 1],
                ['item' => 'Shovel', 'quantity' => 1],
                ['item' => 'Sickle', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 30.00,
            'origin_feat_slug' => 'tough',
        ],
        [
            'name'                => 'Guard',
            'slug'                => 'guard',
            'description'         => 'Your feet ached from long hours walking patrol routes.',
            'skill_proficiencies' => ['athletics', 'perception'],
            'tool_proficiency'    => 'gaming-set',
            'starting_equipment'  => [
                ['item' => 'Spear', 'quantity' => 1],
                ['item' => 'Light Crossbow', 'quantity' => 1],
                ['item' => 'Bolt', 'quantity' => 20],
                ['item' => 'Gaming Set', 'quantity' => 1],
                ['item' => 'Hooded Lantern', 'quantity' => 1],
                ['item' => 'Manacles', 'quantity' => 1],
                ['item' => 'Quiver', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 12.00,
            'origin_feat_slug' => 'alert',
        ],
        [
            'name'                => 'Guide',
            'slug'                => 'guide',
            'description'         => 'You came of age outdoors, far from settled lands.',
            'skill_proficiencies' => ['stealth', 'survival'],
            'tool_proficiency'    => 'cartographers-tools',
            'starting_equipment'  => [
                ['item' => 'Cartographer\'s Tools', 'quantity' => 1],
                ['item' => 'Bedroll', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Tent', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 3.00,
            'origin_feat_slug' => 'magic-initiate-druid',
        ],
        [
            'name'                => 'Hermit',
            'slug'                => 'hermit',
            'description'         => 'You spent years in relative isolation, pursuing solitude and contemplation.',
            'skill_proficiencies' => ['medicine', 'religion'],
            'tool_proficiency'    => 'herbalism-kit',
            'starting_equipment'  => [
                ['item' => 'Herbalism Kit', 'quantity' => 1],
                ['item' => 'Bedroll', 'quantity' => 1],
                ['item' => 'Book (philosophy)', 'quantity' => 1],
                ['item' => 'Lamp', 'quantity' => 1],
                ['item' => 'Oil', 'quantity' => 3],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 16.00,
            'origin_feat_slug' => 'healer',
        ],
        [
            'name'                => 'Merchant',
            'slug'                => 'merchant',
            'description'         => 'You worked for years selling goods in the markets and trade routes.',
            'skill_proficiencies' => ['animal-handling', 'persuasion'],
            'tool_proficiency'    => 'navigators-tools',
            'starting_equipment'  => [
                ['item' => 'Navigator\'s Tools', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 22.00,
            'origin_feat_slug' => 'lucky',
        ],
        [
            'name'                => 'Noble',
            'slug'                => 'noble',
            'description'         => 'You were raised in a castle, surrounded by wealth, power, and privilege.',
            'skill_proficiencies' => ['history', 'persuasion'],
            'tool_proficiency'    => 'gaming-set',
            'starting_equipment'  => [
                ['item' => 'Gaming Set', 'quantity' => 1],
                ['item' => 'Fine Clothes', 'quantity' => 1],
                ['item' => 'Perfume', 'quantity' => 1],
            ],
            'starting_gold'    => 29.00,
            'origin_feat_slug' => 'skilled',
        ],
        [
            'name'                => 'Sage',
            'slug'                => 'sage',
            'description'         => 'You spent years learning the lore of the multiverse.',
            'skill_proficiencies' => ['arcana', 'history'],
            'tool_proficiency'    => 'calligraphers-supplies',
            'starting_equipment'  => [
                ['item' => 'Calligrapher\'s Supplies', 'quantity' => 1],
                ['item' => 'Book (history)', 'quantity' => 1],
                ['item' => 'Parchment', 'quantity' => 8],
                ['item' => 'Robe', 'quantity' => 1],
            ],
            'starting_gold'    => 8.00,
            'origin_feat_slug' => 'magic-initiate-wizard',
        ],
        [
            'name'                => 'Sailor',
            'slug'                => 'sailor',
            'description'         => 'You spent your formative years aboard merchant ships and naval vessels.',
            'skill_proficiencies' => ['acrobatics', 'perception'],
            'tool_proficiency'    => 'navigators-tools',
            'starting_equipment'  => [
                ['item' => 'Navigator\'s Tools', 'quantity' => 1],
                ['item' => 'Dagger', 'quantity' => 1],
                ['item' => 'Rope (50 feet)', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 20.00,
            'origin_feat_slug' => 'tavern-brawler',
        ],
        [
            'name'                => 'Scribe',
            'slug'                => 'scribe',
            'description'         => 'You spent formative years in a scriptorium, copying books and documents.',
            'skill_proficiencies' => ['investigation', 'perception'],
            'tool_proficiency'    => 'calligraphers-supplies',
            'starting_equipment'  => [
                ['item' => 'Calligrapher\'s Supplies', 'quantity' => 1],
                ['item' => 'Fine Clothes', 'quantity' => 1],
                ['item' => 'Lamp', 'quantity' => 1],
                ['item' => 'Oil', 'quantity' => 3],
                ['item' => 'Parchment', 'quantity' => 12],
            ],
            'starting_gold'    => 23.00,
            'origin_feat_slug' => 'skilled',
        ],
        [
            'name'                => 'Soldier',
            'slug'                => 'soldier',
            'description'         => 'You began training for war as soon as you reached adulthood.',
            'skill_proficiencies' => ['athletics', 'intimidation'],
            'tool_proficiency'    => 'gaming-set',
            'starting_equipment'  => [
                ['item' => 'Spear', 'quantity' => 1],
                ['item' => 'Shortbow', 'quantity' => 1],
                ['item' => 'Arrow', 'quantity' => 20],
                ['item' => 'Gaming Set', 'quantity' => 1],
                ['item' => 'Healer\'s Kit', 'quantity' => 1],
                ['item' => 'Quiver', 'quantity' => 1],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 14.00,
            'origin_feat_slug' => 'savage-attacker',
        ],
        [
            'name'                => 'Wayfarer',
            'slug'                => 'wayfarer',
            'description'         => 'You grew up on the streets surrounded by similarly ill-fated orphans.',
            'skill_proficiencies' => ['insight', 'stealth'],
            'tool_proficiency'    => 'thieves-tools',
            'starting_equipment'  => [
                ['item' => 'Thieves\' Tools', 'quantity' => 1],
                ['item' => 'Dagger', 'quantity' => 2],
                ['item' => 'Gaming Set', 'quantity' => 1],
                ['item' => 'Bedroll', 'quantity' => 1],
                ['item' => 'Pouch', 'quantity' => 2],
                ['item' => 'Traveler\'s Clothes', 'quantity' => 1],
            ],
            'starting_gold'    => 16.00,
            'origin_feat_slug' => 'lucky',
        ],
    ];

    public function run(): void
    {
        foreach ($this->backgrounds as $backgroundData) {
            $originFeatSlug = $backgroundData['origin_feat_slug'];
            unset($backgroundData['origin_feat_slug']);

            $feat = Feat::where('slug', $originFeatSlug)->first();

            Background::updateOrCreate(
                ['slug' => $backgroundData['slug']],
                array_merge($backgroundData, [
                    'origin_feat_id' => $feat?->id,
                ])
            );
        }
    }
}
