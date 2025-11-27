<?php

declare(strict_types=1);

namespace App\Enums;

enum Size: string
{
    case Tiny = 'Tiny';
    case Small = 'Small';
    case Medium = 'Medium';
    case Large = 'Large';
    case Huge = 'Huge';
    case Gargantuan = 'Gargantuan';
}
