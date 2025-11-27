<?php

declare(strict_types=1);

namespace App\Enums;

enum Alignment: string
{
    case LawfulGood = 'LG';
    case NeutralGood = 'NG';
    case ChaoticGood = 'CG';
    case LawfulNeutral = 'LN';
    case TrueNeutral = 'N';
    case ChaoticNeutral = 'CN';
    case LawfulEvil = 'LE';
    case NeutralEvil = 'NE';
    case ChaoticEvil = 'CE';
}
