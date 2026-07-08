<?php

namespace App\Enums;

enum Sexe: string
{
    case Masculin = 'M';
    case Feminin = 'F';

    public function label(): string
    {
        return match ($this) {
            self::Masculin => 'Masculin',
            self::Feminin => 'Féminin',
        };
    }
}
