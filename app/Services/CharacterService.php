<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AbilityScore;
use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use function assert;
use function count;
use function in_array;
use function is_array;
use function is_int;
use function is_string;

/**
 * Business logic for character operations.
 *
 * This service handles:
 * - Character CRUD operations
 * - Ability score creation
 * - Derived stats calculation
 * - Data transformation (camelCase to snake_case)
 */
final class CharacterService
{
    /**
     * Create a new character with ability scores.
     *
     * @param array<string, mixed> $data Validated input (camelCase)
     */
    public function create(array $data): Character
    {
        return DB::transaction(function () use ($data): Character {
            // Transform camelCase to snake_case and create character
            $character = Character::create([
                'name'              => $data['name'],
                'class_id'          => $data['classId'],
                'species_id'        => $data['speciesId'],
                'background_id'     => $data['backgroundId'],
                'alignment'         => $data['alignment'] ?? null,
                'level'             => 1,
                'experience_points' => 0,
            ]);

            // Create ability scores
            if (isset($data['abilityScores']) && is_array($data['abilityScores'])) {
                /** @var array<string, int> $scores */
                $scores = $data['abilityScores'];
                $this->createAbilityScores($character, $scores);
            }

            // Calculate derived stats
            $this->calculateDerivedStats($character);

            $freshCharacter = $character->fresh([
                'class',
                'species',
                'background',
                'abilityScores',
            ]);

            // fresh() should never return null for existing model
            assert($freshCharacter !== null);

            return $freshCharacter;
        });
    }

    /**
     * Soft delete a character.
     */
    public function delete(Character $character): bool
    {
        return (bool) $character->delete();
    }

    /**
     * List characters with filtering, sorting, and pagination.
     *
     * @param array<string, mixed> $filters  Filter criteria
     * @param string               $sort     Sort field (prefix with - for desc)
     * @param string               $includes Comma-separated relationships
     * @param int                  $perPage  Items per page
     *
     * @return LengthAwarePaginator<int, Character>
     */
    public function list(
        array $filters = [],
        string $sort = '-createdAt',
        string $includes = '',
        int $perPage = 15,
    ): LengthAwarePaginator {
        $query = Character::query();

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sort);
        $this->applyIncludes($query, $includes);

        /* @var LengthAwarePaginator<int, Character> */
        return $query->paginate($perPage);
    }

    /**
     * Update an existing character.
     *
     * @param array<string, mixed> $data Validated input (camelCase)
     */
    public function update(Character $character, array $data): Character
    {
        return DB::transaction(function () use ($character, $data): Character {
            // Transform and update character fields
            $updateData = [];

            if (isset($data['name'])) {
                $updateData['name'] = $data['name'];
            }

            if (isset($data['alignment'])) {
                $updateData['alignment'] = $data['alignment'];
            }

            if (isset($data['personalityTraits'])) {
                $updateData['personality_traits'] = $data['personalityTraits'];
            }

            if (isset($data['ideals'])) {
                $updateData['ideals'] = $data['ideals'];
            }

            if (isset($data['bonds'])) {
                $updateData['bonds'] = $data['bonds'];
            }

            if (isset($data['flaws'])) {
                $updateData['flaws'] = $data['flaws'];
            }

            if (isset($data['backstory'])) {
                $updateData['backstory'] = $data['backstory'];
            }

            if (isset($data['notes'])) {
                $updateData['notes'] = $data['notes'];
            }

            if (count($updateData) > 0) {
                $character->update($updateData);
            }

            // Update ability scores if provided
            if (isset($data['abilityScores']) && is_array($data['abilityScores'])) {
                /** @var array<string, int> $scores */
                $scores = $data['abilityScores'];
                $this->updateAbilityScores($character, $scores);
                $this->calculateDerivedStats($character);
            }

            $freshCharacter = $character->fresh([
                'class',
                'species',
                'background',
                'abilityScores',
            ]);

            // fresh() should never return null for existing model
            assert($freshCharacter !== null);

            return $freshCharacter;
        });
    }

    /**
     * Apply filters to the query.
     *
     * @param Builder<Character>   $query
     * @param array<string, mixed> $filters
     */
    private function applyFilters(Builder $query, array $filters): void
    {
        if (isset($filters['classId']) && is_string($filters['classId'])) {
            $query->where('class_id', $filters['classId']);
        }

        if (isset($filters['speciesId']) && is_string($filters['speciesId'])) {
            $query->where('species_id', $filters['speciesId']);
        }

        if (isset($filters['backgroundId']) && is_string($filters['backgroundId'])) {
            $query->where('background_id', $filters['backgroundId']);
        }

        if (isset($filters['minLevel']) && (is_int($filters['minLevel']) || is_string($filters['minLevel']))) {
            $query->where('level', '>=', (int) $filters['minLevel']);
        }

        if (isset($filters['maxLevel']) && (is_int($filters['maxLevel']) || is_string($filters['maxLevel']))) {
            $query->where('level', '<=', (int) $filters['maxLevel']);
        }

        if (isset($filters['name']) && is_string($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }
    }

    /**
     * Apply relationship includes to the query.
     *
     * @param Builder<Character> $query
     */
    private function applyIncludes(Builder $query, string $includes): void
    {
        if ($includes === '') {
            // Default includes for list
            $query->with(['class', 'species', 'background']);

            return;
        }

        $allowedIncludes = [
            'class',
            'class.features',
            'species',
            'background',
            'abilityScores',
            'skills',
            'equipment',
            'spells',
            'feats',
        ];

        $requestedIncludes = array_intersect(
            explode(',', $includes),
            $allowedIncludes,
        );

        if (count($requestedIncludes) > 0) {
            $query->with($requestedIncludes);
        }
    }

    /**
     * Apply sorting to the query.
     *
     * @param Builder<Character> $query
     */
    private function applySorting(Builder $query, string $sort): void
    {
        $direction = 'asc';

        if (str_starts_with($sort, '-')) {
            $direction = 'desc';
            $sort      = substr($sort, 1);
        }

        // Map camelCase to snake_case
        $columnMap = [
            'createdAt'        => 'created_at',
            'updatedAt'        => 'updated_at',
            'experiencePoints' => 'experience_points',
            'maxHitPoints'     => 'max_hit_points',
        ];

        $column = $columnMap[$sort] ?? $sort;

        $allowedColumns = ['name', 'level', 'created_at', 'updated_at', 'experience_points'];

        if (in_array($column, $allowedColumns, true)) {
            /* @phpstan-ignore staticMethod.dynamicCall */
            $query->orderBy($column, $direction);
        }
    }

    /**
     * Calculate and update derived stats based on class, species, and ability scores.
     */
    private function calculateDerivedStats(Character $character): void
    {
        $character->load(['class', 'species', 'abilityScores']);

        // Calculate max HP: hit die max + CON modifier at level 1
        $class  = $character->class;
        $hitDie = $class !== null ? $class->hit_die : 8;

        $abilityScores = $character->abilityScores;
        $conMod        = $abilityScores !== null ? $abilityScores->constitution_modifier : 0;
        $maxHp         = $hitDie + $conMod;

        // Speed from species
        $species = $character->species;
        $speed   = $species !== null ? $species->speed : 30;

        // Proficiency bonus (always 2 at level 1)
        $proficiencyBonus = (int) ceil($character->level / 4) + 1;

        // Initiative = DEX modifier
        $initiative = $abilityScores !== null ? $abilityScores->dexterity_modifier : 0;

        // Base armor class (10 + DEX modifier)
        $armorClass = 10 + ($abilityScores !== null ? $abilityScores->dexterity_modifier : 0);

        $character->update([
            'max_hit_points'     => $maxHp,
            'current_hit_points' => $maxHp,
            'speed'              => $speed,
            'proficiency_bonus'  => $proficiencyBonus,
            'initiative_bonus'   => $initiative,
            'armor_class'        => $armorClass,
        ]);
    }

    /**
     * Create ability scores for a character.
     *
     * @param array<string, int> $scores
     */
    private function createAbilityScores(Character $character, array $scores): void
    {
        AbilityScore::create([
            'character_id' => $character->id,
            'strength'     => $scores['strength'],
            'dexterity'    => $scores['dexterity'],
            'constitution' => $scores['constitution'],
            'intelligence' => $scores['intelligence'],
            'wisdom'       => $scores['wisdom'],
            'charisma'     => $scores['charisma'],
        ]);
    }

    /**
     * Update ability scores for a character.
     *
     * @param array<string, int> $scores
     */
    private function updateAbilityScores(Character $character, array $scores): void
    {
        $abilityScores = $character->abilityScores;

        if ($abilityScores === null) {
            $this->createAbilityScores($character, $scores);

            return;
        }

        $abilityScores->update($scores);
    }
}
