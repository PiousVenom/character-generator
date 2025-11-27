<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AbilityScore;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Species;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CharacterService
{
    public function __construct(
        private readonly AbilityScoreService $abilityScoreService,
        private readonly CombatStatisticsService $combatService,
    ) {
    }

    /**
     * @param array{name: string, classId: string, speciesId: string, backgroundId: string, alignment: string, abilityScores: array{strength: int, dexterity: int, constitution: int, intelligence: int, wisdom: int, charisma: int}} $data
     */
    public function create(array $data): Character
    {
        return DB::transaction(function () use ($data): Character {
            $class = CharacterClass::findOrFail($data['classId']);
            $species = Species::findOrFail($data['speciesId']);

            $character = new Character([
                'name' => $data['name'],
                'class_id' => $data['classId'],
                'species_id' => $data['speciesId'],
                'background_id' => $data['backgroundId'],
                'alignment' => $data['alignment'],
                'level' => 1,
                'experience_points' => 0,
                'speed' => $species->speed,
                'proficiency_bonus' => 2,
                'inspiration' => false,
            ]);

            // Calculate initial stats
            $abilityScores = $data['abilityScores'];
            $constitutionModifier = $this->abilityScoreService->calculateModifier(
                $abilityScores['constitution'],
            );

            $character->max_hit_points = $this->combatService->calculateStartingHitPoints(
                $class,
                $constitutionModifier,
            );
            $character->current_hit_points = $character->max_hit_points;
            $character->temporary_hit_points = 0;

            $dexterityModifier = $this->abilityScoreService->calculateModifier(
                $abilityScores['dexterity'],
            );
            $character->armor_class = 10 + $dexterityModifier;
            $character->initiative_bonus = $dexterityModifier;

            $character->save();

            // Create ability scores
            AbilityScore::create([
                'character_id' => $character->id,
                'strength' => $abilityScores['strength'],
                'dexterity' => $abilityScores['dexterity'],
                'constitution' => $abilityScores['constitution'],
                'intelligence' => $abilityScores['intelligence'],
                'wisdom' => $abilityScores['wisdom'],
                'charisma' => $abilityScores['charisma'],
            ]);

            return $character->load(['characterClass', 'species', 'background', 'abilityScores']);
        });
    }

    /**
     * @param array<string, mixed> $data
     */
    public function update(Character $character, array $data): Character
    {
        $character->update($data);

        $updated = $character->fresh(['characterClass', 'species', 'background', 'abilityScores']);

        if ($updated === null) {
            throw new RuntimeException('Failed to refresh character after update');
        }

        return $updated;
    }

    public function delete(Character $character): void
    {
        $character->delete();
    }
}
