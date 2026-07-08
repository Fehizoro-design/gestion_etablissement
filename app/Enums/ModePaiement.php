<?php

namespace App\Enums;

enum ModePaiement: string
{
    case Especes = 'especes';
    case Virement = 'virement';
    case Cheque = 'cheque';
    case MobileMoney = 'mobile_money';

    public function label(): string
    {
        return match ($this) {
            self::Especes => 'Espèces',
            self::Virement => 'Virement',
            self::Cheque => 'Chèque',
            self::MobileMoney => 'Mobile Money',
        };
    }
}
