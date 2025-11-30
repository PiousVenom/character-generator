<?php

declare(strict_types=1);

namespace Tests\Feature\Database;

use App\Models\AbilityScore;
use App\Models\Background;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use App\Models\Subclass;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use function in_array;

final class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Application tables created by migrations (excludes Laravel framework tables).
     */
    private const array APPLICATION_TABLES = [
        'classes',
        'species',
        'backgrounds',
        'skills',
        'equipment',
        'spells',
        'feats',
        'subclasses',
        'class_features',
        'class_spells',
        'characters',
        'ability_scores',
        'character_skills',
        'character_equipment',
        'character_spells',
        'character_feats',
        'error_logs',
        'request_logs',
    ];

    public function testAbilityScoresTableHasForeignKeyToCharacters(): void
    {
        $this->assertTrue(
            Schema::hasColumn('ability_scores', 'character_id'),
            'Ability scores table should have character_id column',
        );

        $this->assertForeignKeyExists('ability_scores', 'character_id');
    }

    public function testAbilityScoresTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('ability_scores');
    }

    public function testAbilityScoresTableHasUniqueCharacterIdConstraint(): void
    {
        $this->assertUniqueConstraintExists('ability_scores', 'character_id');
    }

    public function testAbilityScoresTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('ability_scores');
    }

    public function testAllApplicationTablesExist(): void
    {
        foreach (self::APPLICATION_TABLES as $table) {
            $this->assertTrue(
                Schema::hasTable($table),
                "Table '{$table}' should exist",
            );
        }
    }

    public function testBackgroundsTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('backgrounds');
    }

    public function testBackgroundsTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('backgrounds');
    }

    // =====================================
    // Foreign Key Constraint Behavior Tests
    // =====================================

    public function testCascadeDeleteRemovesAbilityScoresWhenCharacterDeleted(): void
    {
        // SQLite requires foreign keys to be enabled
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $character = Character::factory()->create();

        $abilityScore = AbilityScore::factory()->for($character)->create();

        $this->assertDatabaseHas('ability_scores', ['id' => $abilityScore->id]);

        // Force delete (not soft delete) to trigger cascade
        $character->forceDelete();

        $this->assertDatabaseMissing('ability_scores', ['id' => $abilityScore->id]);
    }

    public function testCharactersTableHasForeignKeyToBackgrounds(): void
    {
        $this->assertTrue(
            Schema::hasColumn('characters', 'background_id'),
            'Characters table should have background_id column',
        );

        $this->assertForeignKeyExists('characters', 'background_id');
    }

    public function testCharactersTableHasForeignKeyToClasses(): void
    {
        $this->assertTrue(
            Schema::hasColumn('characters', 'class_id'),
            'Characters table should have class_id column',
        );

        $this->assertForeignKeyExists('characters', 'class_id');
    }

    public function testCharactersTableHasForeignKeyToSpecies(): void
    {
        $this->assertTrue(
            Schema::hasColumn('characters', 'species_id'),
            'Characters table should have species_id column',
        );

        $this->assertForeignKeyExists('characters', 'species_id');
    }

    public function testCharactersTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('characters');
    }

    public function testCharactersTableHasTimestamps(): void
    {
        $this->assertTableHasTimestamps('characters');
    }

    public function testCharactersTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('characters');
    }

    public function testClassesTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('classes');
    }

    public function testClassesTableHasTimestamps(): void
    {
        $this->assertTableHasTimestamps('classes');
    }

    public function testClassesTableHasUniqueNameConstraint(): void
    {
        $this->assertUniqueConstraintExists('classes', 'name');
    }

    public function testClassesTableHasUniqueSlugConstraint(): void
    {
        $this->assertUniqueConstraintExists('classes', 'slug');
    }

    public function testClassesTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('classes');
    }

    public function testClassFeaturesTableHasForeignKeyToClasses(): void
    {
        $this->assertTrue(
            Schema::hasColumn('class_features', 'class_id'),
            'Class features table should have class_id column',
        );

        $this->assertForeignKeyExists('class_features', 'class_id');
    }

    public function testErrorLogsTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('error_logs');
    }

    public function testErrorLogsTableHasTimestamps(): void
    {
        $this->assertTableHasTimestamps('error_logs');
    }

    public function testErrorLogsTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('error_logs');
    }

    public function testRequestLogsTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('request_logs');
    }

    public function testRequestLogsTableHasTimestamps(): void
    {
        $this->assertTableHasTimestamps('request_logs');
    }

    public function testRequestLogsTableHasUniqueCorrelationIdConstraint(): void
    {
        $this->assertUniqueConstraintExists('request_logs', 'correlation_id');
    }

    public function testRequestLogsTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('request_logs');
    }

    public function testRestrictPreventsBackgroundDeletionWhenReferencedByCharacter(): void
    {
        // SQLite requires foreign keys to be enabled
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $background = Background::factory()->create();

        Character::factory()->state(['background_id' => $background->id])->create();

        $this->expectException(QueryException::class);

        // Force delete (not soft delete) to trigger constraint
        $background->forceDelete();
    }

    public function testRestrictPreventsClassDeletionWhenReferencedByCharacter(): void
    {
        // SQLite requires foreign keys to be enabled
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $class = CharacterClass::factory()->create();

        Character::factory()->state(['class_id' => $class->id])->create();

        $this->expectException(QueryException::class);

        // Force delete (not soft delete) to trigger constraint
        $class->forceDelete();
    }

    public function testRestrictPreventsSpeciesDeletionWhenReferencedByCharacter(): void
    {
        // SQLite requires foreign keys to be enabled
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $species = Species::factory()->create();

        Character::factory()->state(['species_id' => $species->id])->create();

        $this->expectException(QueryException::class);

        // Force delete (not soft delete) to trigger constraint
        $species->forceDelete();
    }

    public function testSetNullSetsSubclassIdToNullWhenSubclassDeleted(): void
    {
        // SQLite requires foreign keys to be enabled
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $class    = CharacterClass::factory()->create();
        $subclass = Subclass::factory()->for($class, 'class')->create();

        $character = Character::factory()
            ->state([
                'class_id'    => $class->id,
                'subclass_id' => $subclass->id,
                'level'       => 3, // Subclasses typically available at level 3+
            ])
            ->create();

        $this->assertSame($subclass->id, $character->subclass_id);

        // Force delete (not soft delete) to trigger SET NULL
        $subclass->forceDelete();

        $character->refresh();

        $this->assertNull($character->subclass_id);
    }

    public function testSpeciesTableHasSoftDeletes(): void
    {
        $this->assertTableHasSoftDeletes('species');
    }

    public function testSpeciesTableHasUniqueNameConstraint(): void
    {
        $this->assertUniqueConstraintExists('species', 'name');
    }

    public function testSpeciesTableHasUuidPrimaryKey(): void
    {
        $this->assertTableHasUuidPrimaryKey('species');
    }

    public function testSubclassesTableHasForeignKeyToClasses(): void
    {
        $this->assertTrue(
            Schema::hasColumn('subclasses', 'class_id'),
            'Subclasses table should have class_id column',
        );

        $this->assertForeignKeyExists('subclasses', 'class_id');
    }

    private function assertForeignKeyExists(string $table, string $column): void
    {
        /** @var array<int, array{columns: array<string>}> $foreignKeys */
        $foreignKeys = Schema::getForeignKeys($table);

        $columnFK = null;
        foreach ($foreignKeys as $fk) {
            if (in_array($column, $fk['columns'], true)) {
                $columnFK = $fk;
                break;
            }
        }

        $this->assertNotNull($columnFK, "Foreign key on '{$column}' in '{$table}' should exist");
    }

    private function assertTableHasSoftDeletes(string $table): void
    {
        $this->assertTrue(
            Schema::hasColumn($table, 'deleted_at'),
            "Table '{$table}' should have 'deleted_at' column for soft deletes",
        );
    }

    private function assertTableHasTimestamps(string $table): void
    {
        $this->assertTrue(
            Schema::hasColumn($table, 'created_at'),
            "Table '{$table}' should have 'created_at' column",
        );

        $this->assertTrue(
            Schema::hasColumn($table, 'updated_at'),
            "Table '{$table}' should have 'updated_at' column",
        );
    }

    private function assertTableHasUuidPrimaryKey(string $table): void
    {
        $this->assertTrue(
            Schema::hasColumn($table, 'id'),
            "Table '{$table}' should have 'id' column",
        );

        /** @var array<int, array{name: string, type: string}> $columns */
        $columns  = Schema::getColumns($table);
        $idColumn = collect($columns)->firstWhere('name', 'id');

        $this->assertNotNull($idColumn, "Could not find 'id' column in '{$table}'");
        $this->assertIsArray($idColumn);
        $this->assertArrayHasKey('type', $idColumn);

        $columnType = $idColumn['type'];

        // UUID columns in SQLite (testing) can be varchar/text, in MySQL are char(36) or varchar(36)
        // SQLite may report type as just 'varchar' without length specification
        $this->assertMatchesRegularExpression(
            '/^(char|varchar)(\(36\))?|text$/i',
            $columnType,
            "Table '{$table}' should have UUID-compatible primary key, got: {$columnType}",
        );
    }

    private function assertUniqueConstraintExists(string $table, string $column): void
    {
        /** @var array<int, array{columns: array<string>, unique: bool}> $indexes */
        $indexes = Schema::getIndexes($table);

        $uniqueIndex = null;
        foreach ($indexes as $index) {
            if (in_array($column, $index['columns'], true) && $index['unique'] === true) {
                $uniqueIndex = $index;
                break;
            }
        }

        $this->assertNotNull($uniqueIndex, "Unique constraint on '{$column}' in '{$table}' should exist");
    }
}
