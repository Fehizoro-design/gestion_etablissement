<?php

namespace App\Enums;

enum StatutPaiement: string
{
    case Paye = 'paye';
    case Partiel = 'partiel';
    case EnAttente = 'en_attente';

    public function label(): string
    {
        return match ($this) {
            self::Paye => 'Payé',
            self::Partiel => 'Partiel',
            self::EnAttente => 'En attente',
        };
    }
}
