<?php

declare(strict_types=1);

namespace App\Services;

final class AbilityScoreService
{
    public function calculateModifier(int $score): int
    {
        return (int) floor(($score - 10) / 2);
    }

    /**
     * @param array<int> $scores
     */
    public function validateStandardArray(array $scores): bool
    {
        $standardArray = [15, 14, 13, 12, 10, 8];
        $sortedScores = $scores;
        sort($sortedScores);
        sort($standardArray);

        return $sortedScores === $standardArray;
    }
}
