<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Classe;
use App\Models\Etablissement;
use App\Models\Niveau;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classe>
 */
class ClasseFactory extends Factory
{
    protected $model = Classe::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etablissement_id' => Etablissement::factory(),
            'niveau_id' => Niveau::factory(),
            'annee_scolaire_id' => AnneeScolaire::factory(),
            'nom' => fake()->randomElement(['A', 'B', 'C']),
            'capacite_max' => fake()->numberBetween(25, 50),
        ];
    }
}
