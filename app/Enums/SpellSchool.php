<?php

declare(strict_types=1);

namespace App\Enums;

enum SpellSchool: string
{
    case Abjuration = 'Abjuration';
    case Conjuration = 'Conjuration';
    case Divination = 'Divination';
    case Enchantment = 'Enchantment';
    case Evocation = 'Evocation';
    case Illusion = 'Illusion';
    case Necromancy = 'Necromancy';
    case Transmutation = 'Transmutation';
}
