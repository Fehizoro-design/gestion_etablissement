<?php

namespace App\Enums;

enum RoleEtablissement: string
{
    case Proprietaire = 'proprietaire';
    case Directeur = 'directeur';
    case Secretaire = 'secretaire';
    case Comptable = 'comptable';

    public function label(): string
    {
        return match ($this) {
            self::Proprietaire => 'Propriétaire',
            self::Directeur => 'Directeur',
            self::Secretaire => 'Secrétaire',
            self::Comptable => 'Comptable',
        };
    }
}
