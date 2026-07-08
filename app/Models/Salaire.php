<?php

namespace App\Models;

use App\Enums\ModePaiement;
use App\Enums\StatutSalaire;
use Database\Factories\SalaireFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'enseignant_id', 'montant', 'mois', 'annee',
    'date_paiement', 'statut', 'mode_paiement', 'reference', 'remarques',
])]
class Salaire extends Model
{
    /** @use HasFactory<SalaireFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'date_paiement' => 'date',
            'statut' => StatutSalaire::class,
            'mode_paiement' => ModePaiement::class,
        ];
    }

    /** @return BelongsTo<Enseignant, $this> */
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    /**
     * Get the month name.
     */
    public function moisLibelle(): string
    {
        $mois = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
            4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
            10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
        ];

        return $mois[$this->mois] ?? '';
    }
}
