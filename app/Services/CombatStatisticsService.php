<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CharacterClass;

final class CombatStatisticsService
{
    public function calculateStartingHitPoints(CharacterClass $class, int $constitutionModifier): int
    {
        $hitDieMax = $this->getHitDieMaximum($class->hit_die);

        return $hitDieMax + $constitutionModifier;
    }

    public function getHitDieMaximum(string $hitDie): int
    {
        return match ($hitDie) {
            'd6' => 6,
            'd8' => 8,
            'd10' => 10,
            'd12' => 12,
            default => 8,
        };
    }

    public function calculateProficiencyBonus(int $level): int
    {
        return (int) ceil($level / 4) + 1;
    }
}
