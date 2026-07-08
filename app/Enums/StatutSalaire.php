<?php

namespace App\Enums;

enum StatutSalaire: string
{
    case EnAttente = 'en_attente';
    case Paye = 'paye';
    case Annule = 'annule';

    public function label(): string
    {
        return match ($this) {
            self::EnAttente => 'En attente',
            self::Paye => 'Payé',
            self::Annule => 'Annulé',
        };
    }
}
