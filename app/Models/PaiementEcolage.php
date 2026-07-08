<?php

namespace App\Models;

use App\Enums\ModePaiement;
use App\Enums\StatutPaiement;
use Database\Factories\PaiementEcolageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'eleve_id', 'annee_scolaire_id', 'montant', 'mois_concerne',
    'date_paiement', 'statut', 'mode_paiement', 'reference',
    'montant_restant', 'remarques',
])]
class PaiementEcolage extends Model
{
    /** @use HasFactory<PaiementEcolageFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'montant' => 'decimal:2',
            'montant_restant' => 'decimal:2',
            'date_paiement' => 'date',
            'statut' => StatutPaiement::class,
            'mode_paiement' => ModePaiement::class,
        ];
    }

    /** @return BelongsTo<Eleve, $this> */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /** @return BelongsTo<AnneeScolaire, $this> */
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
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

        return $mois[$this->mois_concerne] ?? '';
    }
}
