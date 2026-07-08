<?php

namespace App\Enums;

enum TypeNote: string
{
    case Devoir = 'devoir';
    case Examen = 'examen';
    case Interrogation = 'interrogation';
    case Tp = 'tp';
    case Projet = 'projet';

    public function label(): string
    {
        return match ($this) {
            self::Devoir => 'Devoir',
            self::Examen => 'Examen',
            self::Interrogation => 'Interrogation',
            self::Tp => 'Travaux Pratiques',
            self::Projet => 'Projet',
        };
    }
}
