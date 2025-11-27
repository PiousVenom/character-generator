<?php

declare(strict_types=1);

namespace App\Enums;

enum EquipmentType: string
{
    case Weapon = 'Weapon';
    case Armor = 'Armor';
    case AdventuringGear = 'Adventuring Gear';
    case Tool = 'Tool';
    case Mount = 'Mount';
    case Vehicle = 'Vehicle';
}
