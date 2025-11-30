<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CharacterClass;
use App\Models\Spell;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

final class ClassSpellSeeder extends Seeder
{
    /**
     * @var array<string, array<array{spell_slug: string, level_available: int}>>
     */
    private array $classSpells = [
        'wizard' => [
            ['spell_slug' => 'fire-bolt', 'level_available' => 1],
            ['spell_slug' => 'light', 'level_available' => 1],
            ['spell_slug' => 'mage-hand', 'level_available' => 1],
            ['spell_slug' => 'prestidigitation', 'level_available' => 1],
            ['spell_slug' => 'minor-illusion', 'level_available' => 1],
            ['spell_slug' => 'magic-missile', 'level_available' => 1],
            ['spell_slug' => 'shield', 'level_available' => 1],
            ['spell_slug' => 'detect-magic', 'level_available' => 1],
            ['spell_slug' => 'sleep', 'level_available' => 1],
            ['spell_slug' => 'scorching-ray', 'level_available' => 3],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'misty-step', 'level_available' => 3],
            ['spell_slug' => 'fireball', 'level_available' => 5],
            ['spell_slug' => 'lightning-bolt', 'level_available' => 5],
            ['spell_slug' => 'counterspell', 'level_available' => 5],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
            ['spell_slug' => 'dimension-door', 'level_available' => 7],
            ['spell_slug' => 'greater-invisibility', 'level_available' => 7],
            ['spell_slug' => 'cone-of-cold', 'level_available' => 9],
            ['spell_slug' => 'wall-of-force', 'level_available' => 9],
        ],
        'cleric' => [
            ['spell_slug' => 'sacred-flame', 'level_available' => 1],
            ['spell_slug' => 'light', 'level_available' => 1],
            ['spell_slug' => 'cure-wounds', 'level_available' => 1],
            ['spell_slug' => 'detect-magic', 'level_available' => 1],
            ['spell_slug' => 'bless', 'level_available' => 1],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
        ],
        'bard' => [
            ['spell_slug' => 'light', 'level_available' => 1],
            ['spell_slug' => 'mage-hand', 'level_available' => 1],
            ['spell_slug' => 'prestidigitation', 'level_available' => 1],
            ['spell_slug' => 'minor-illusion', 'level_available' => 1],
            ['spell_slug' => 'cure-wounds', 'level_available' => 1],
            ['spell_slug' => 'detect-magic', 'level_available' => 1],
            ['spell_slug' => 'sleep', 'level_available' => 1],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
            ['spell_slug' => 'dimension-door', 'level_available' => 7],
            ['spell_slug' => 'greater-invisibility', 'level_available' => 7],
        ],
        'sorcerer' => [
            ['spell_slug' => 'fire-bolt', 'level_available' => 1],
            ['spell_slug' => 'light', 'level_available' => 1],
            ['spell_slug' => 'mage-hand', 'level_available' => 1],
            ['spell_slug' => 'prestidigitation', 'level_available' => 1],
            ['spell_slug' => 'magic-missile', 'level_available' => 1],
            ['spell_slug' => 'shield', 'level_available' => 1],
            ['spell_slug' => 'detect-magic', 'level_available' => 1],
            ['spell_slug' => 'sleep', 'level_available' => 1],
            ['spell_slug' => 'scorching-ray', 'level_available' => 3],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'misty-step', 'level_available' => 3],
            ['spell_slug' => 'fireball', 'level_available' => 5],
            ['spell_slug' => 'lightning-bolt', 'level_available' => 5],
            ['spell_slug' => 'counterspell', 'level_available' => 5],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
            ['spell_slug' => 'dimension-door', 'level_available' => 7],
            ['spell_slug' => 'greater-invisibility', 'level_available' => 7],
            ['spell_slug' => 'cone-of-cold', 'level_available' => 9],
            ['spell_slug' => 'wall-of-force', 'level_available' => 9],
        ],
        'warlock' => [
            ['spell_slug' => 'minor-illusion', 'level_available' => 1],
            ['spell_slug' => 'prestidigitation', 'level_available' => 1],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'misty-step', 'level_available' => 3],
            ['spell_slug' => 'counterspell', 'level_available' => 5],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
            ['spell_slug' => 'dimension-door', 'level_available' => 7],
        ],
        'druid' => [
            ['spell_slug' => 'cure-wounds', 'level_available' => 1],
            ['spell_slug' => 'detect-magic', 'level_available' => 1],
            ['spell_slug' => 'hold-person', 'level_available' => 3],
            ['spell_slug' => 'dispel-magic', 'level_available' => 5],
        ],
        'ranger' => [
            ['spell_slug' => 'cure-wounds', 'level_available' => 2],
            ['spell_slug' => 'detect-magic', 'level_available' => 2],
        ],
        'paladin' => [
            ['spell_slug' => 'cure-wounds', 'level_available' => 2],
            ['spell_slug' => 'detect-magic', 'level_available' => 2],
            ['spell_slug' => 'bless', 'level_available' => 2],
            ['spell_slug' => 'dispel-magic', 'level_available' => 9],
        ],
    ];

    public function run(): void
    {
        foreach ($this->classSpells as $classSlug => $spells) {
            $class = CharacterClass::where('slug', $classSlug)->first();

            if ($class === null) {
                continue;
            }

            foreach ($spells as $spellData) {
                $spell = Spell::where('slug', $spellData['spell_slug'])->first();

                if ($spell === null) {
                    continue;
                }

                // Check if record exists for idempotency
                $exists = DB::table('class_spells')
                    ->where('class_id', $class->id)
                    ->where('spell_id', $spell->id)
                    ->exists();

                if ($exists) {
                    DB::table('class_spells')
                        ->where('class_id', $class->id)
                        ->where('spell_id', $spell->id)
                        ->update([
                            'level_available' => $spellData['level_available'],
                            'updated_at'      => now(),
                        ]);
                } else {
                    DB::table('class_spells')->insert([
                        'id'              => Str::uuid()->toString(),
                        'class_id'        => $class->id,
                        'spell_id'        => $spell->id,
                        'level_available' => $spellData['level_available'],
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ]);
                }
            }
        }
    }
}
