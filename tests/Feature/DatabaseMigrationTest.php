<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

final class DatabaseMigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that all required tables exist in the database.
     */
    public function test_all_tables_exist(): void
    {
        $tables = [
            'users',
            'classes',
            'species',
            'backgrounds',
            'skills',
            'equipment',
            'spells',
            'feats',
            'subclasses',
            'class_features',
            'class_spell',
            'characters',
            'ability_scores',
            'character_skills',
            'character_equipment',
            'character_spells',
            'character_feats',
            'character_levels',
            'error_logs',
            'request_logs',
        ];

        foreach ($tables as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Table '{$table}' does not exist in the database.",
            );
        }
    }

    /**
     * Test that the characters table has correct columns.
     */
    public function test_characters_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'class_id',
            'species_id',
            'background_id',
            'subclass_id',
            'level',
            'experience_points',
            'alignment',
            'max_hit_points',
            'current_hit_points',
            'temporary_hit_points',
            'armor_class',
            'initiative_bonus',
            'speed',
            'proficiency_bonus',
            'inspiration',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('characters', $column),
                "Column '{$column}' does not exist in 'characters' table.",
            );
        }
    }

    /**
     * Test that the ability_scores table has correct columns.
     */
    public function test_ability_scores_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'character_id',
            'strength',
            'dexterity',
            'constitution',
            'intelligence',
            'wisdom',
            'charisma',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('ability_scores', $column),
                "Column '{$column}' does not exist in 'ability_scores' table.",
            );
        }
    }

    /**
     * Test that the classes table has correct columns.
     */
    public function test_classes_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'description',
            'hit_die',
            'primary_ability',
            'saving_throw_proficiencies',
            'armor_proficiencies',
            'weapon_proficiencies',
            'tool_proficiencies',
            'skill_choices_count',
            'skill_choices_list',
            'spellcasting_ability',
            'spell_slots_progression',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('classes', $column),
                "Column '{$column}' does not exist in 'classes' table.",
            );
        }
    }

    /**
     * Test that the species table has correct columns.
     */
    public function test_species_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'description',
            'size',
            'speed',
            'ability_score_increases',
            'languages',
            'traits',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('species', $column),
                "Column '{$column}' does not exist in 'species' table.",
            );
        }
    }

    /**
     * Test that the skills table has correct columns.
     */
    public function test_skills_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'ability',
            'description',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('skills', $column),
                "Column '{$column}' does not exist in 'skills' table.",
            );
        }
    }

    /**
     * Test that the spells table has correct columns.
     */
    public function test_spells_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'level',
            'school',
            'casting_time',
            'range',
            'components',
            'duration',
            'concentration',
            'ritual',
            'description',
            'higher_levels',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('spells', $column),
                "Column '{$column}' does not exist in 'spells' table.",
            );
        }
    }

    /**
     * Test that the equipment table has correct columns.
     */
    public function test_equipment_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'name',
            'type',
            'description',
            'cost_copper',
            'weight',
            'properties',
            'weapon_properties',
            'armor_properties',
            'requires_attunement',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('equipment', $column),
                "Column '{$column}' does not exist in 'equipment' table.",
            );
        }
    }

    /**
     * Test that the character_skills pivot table has correct columns.
     */
    public function test_character_skills_table_has_correct_columns(): void
    {
        $columns = [
            'id',
            'character_id',
            'skill_id',
            'is_proficient',
            'has_expertise',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach ($columns as $column) {
            $this->assertTrue(
                Schema::hasColumn('character_skills', $column),
                "Column '{$column}' does not exist in 'character_skills' table.",
            );
        }
    }
}
