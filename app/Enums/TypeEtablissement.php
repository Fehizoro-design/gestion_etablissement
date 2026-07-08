<?php

namespace App\Enums;

enum TypeEtablissement: string
{
    case Primaire = 'primaire';
    case College = 'college';
    case Lycee = 'lycee';
    case Universite = 'universite';
    case Autre = 'autre';

    public function label(): string
    {
        return match ($this) {
            self::Primaire => 'Primaire',
            self::College => 'Collège',
            self::Lycee => 'Lycée',
            self::Universite => 'Université',
            self::Autre => 'Autre',
        };
    }
}
