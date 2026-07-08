<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Periode>
 */
class PeriodeFactory extends Factory
{
    protected $model = Periode::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'annee_scolaire_id' => AnneeScolaire::factory(),
            'libelle' => 'Trimestre '.fake()->numberBetween(1, 3),
            'date_debut' => fake()->date(),
            'date_fin' => fake()->date(),
            'ordre' => fake()->numberBetween(1, 3),
        ];
    }
}
