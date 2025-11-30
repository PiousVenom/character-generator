<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Seeders are called in dependency order:
     * 1. Independent tables first (Skills, Feats, Classes, Species, Equipment, Spells)
     * 2. Tables with foreign keys second (Backgrounds -> Feats, Subclasses -> Classes)
     * 3. Junction/feature tables last (ClassFeatures, ClassSpells)
     */
    public function run(): void
    {
        // Create test user for development
        User::factory()->create([
            'name'  => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed D&D reference data in dependency order
        $this->call([
            // Independent tables (no foreign key dependencies)
            SkillSeeder::class,
            FeatSeeder::class,
            ClassSeeder::class,
            SpeciesSeeder::class,
            EquipmentSeeder::class,
            SpellSeeder::class,

            // Tables with foreign key dependencies
            BackgroundSeeder::class,    // Depends on Feats (origin_feat_id)
            SubclassSeeder::class,      // Depends on Classes (class_id)

            // Feature and junction tables
            ClassFeatureSeeder::class,  // Depends on Classes, Subclasses
            ClassSpellSeeder::class,    // Depends on Classes, Spells
        ]);
    }
}
