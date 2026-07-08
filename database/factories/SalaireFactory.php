<?php

namespace Database\Factories;

use App\Enums\ModePaiement;
use App\Enums\StatutSalaire;
use App\Models\Enseignant;
use App\Models\Salaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Salaire>
 */
class SalaireFactory extends Factory
{
    protected $model = Salaire::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'enseignant_id' => Enseignant::factory(),
            'montant' => fake()->randomFloat(2, 300000, 1500000),
            'mois' => fake()->numberBetween(1, 12),
            'annee' => fake()->numberBetween(2024, 2026),
            'date_paiement' => fake()->optional(0.7)->dateTimeBetween('-1 year', 'now'),
            'statut' => fake()->randomElement(StatutSalaire::cases()),
            'mode_paiement' => fake()->randomElement(ModePaiement::cases()),
        ];
    }
}
