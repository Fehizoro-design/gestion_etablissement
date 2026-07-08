<?php

namespace Database\Factories;

use App\Enums\ModePaiement;
use App\Enums\StatutPaiement;
use App\Models\AnneeScolaire;
use App\Models\Eleve;
use App\Models\PaiementEcolage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PaiementEcolage>
 */
class PaiementEcolageFactory extends Factory
{
    protected $model = PaiementEcolage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'eleve_id' => Eleve::factory(),
            'annee_scolaire_id' => AnneeScolaire::factory(),
            'montant' => fake()->randomFloat(2, 30000, 150000),
            'mois_concerne' => fake()->numberBetween(1, 12),
            'date_paiement' => fake()->dateTimeBetween('-1 year', 'now'),
            'statut' => fake()->randomElement(StatutPaiement::cases()),
            'mode_paiement' => fake()->randomElement(ModePaiement::cases()),
            'montant_restant' => fake()->optional(0.3)->randomFloat(2, 0, 50000) ?? 0,
        ];
    }
}
