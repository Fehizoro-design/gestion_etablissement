<?php

namespace App\Enums;

enum StatutEleve: string
{
    case Inscrit = 'inscrit';
    case Transfere = 'transfere';
    case Exclu = 'exclu';
    case Diplome = 'diplome';

    public function label(): string
    {
        return match ($this) {
            self::Inscrit => 'Inscrit',
            self::Transfere => 'Transféré',
            self::Exclu => 'Exclu',
            self::Diplome => 'Diplômé',
        };
    }
}
