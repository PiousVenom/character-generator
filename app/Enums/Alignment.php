<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * D&D character alignment options.
 *
 * Note: Alignment is optional in the 2024 ruleset but still
 * commonly used for character roleplay purposes.
 */
enum Alignment: string
{
    /**
     * Get human-readable label.
     */
    public function label(): string
    {
        return match ($this) {
            self::LAWFUL_GOOD     => 'Lawful Good',
            self::NEUTRAL_GOOD    => 'Neutral Good',
            self::CHAOTIC_GOOD    => 'Chaotic Good',
            self::LAWFUL_NEUTRAL  => 'Lawful Neutral',
            self::TRUE_NEUTRAL    => 'True Neutral',
            self::CHAOTIC_NEUTRAL => 'Chaotic Neutral',
            self::LAWFUL_EVIL     => 'Lawful Evil',
            self::NEUTRAL_EVIL    => 'Neutral Evil',
            self::CHAOTIC_EVIL    => 'Chaotic Evil',
        };
    }

    /**
     * Get all alignment values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    case CHAOTIC_EVIL    = 'chaotic_evil';
    case CHAOTIC_GOOD    = 'chaotic_good';
    case CHAOTIC_NEUTRAL = 'chaotic_neutral';
    case LAWFUL_EVIL     = 'lawful_evil';
    case LAWFUL_GOOD     = 'lawful_good';
    case LAWFUL_NEUTRAL  = 'lawful_neutral';
    case NEUTRAL_EVIL    = 'neutral_evil';
    case NEUTRAL_GOOD    = 'neutral_good';
    case TRUE_NEUTRAL    = 'true_neutral';
}
