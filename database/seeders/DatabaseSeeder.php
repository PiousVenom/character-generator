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
     */
    public function run(): void
    {
        // Seed reference data first (independent tables)
        $this->call([
            SkillSeeder::class,
            ClassSeeder::class,
            SpeciesSeeder::class,
            BackgroundSeeder::class,
            EquipmentSeeder::class,
            SpellSeeder::class,
            FeatSeeder::class,
        ]);

        // Create test user for development
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
