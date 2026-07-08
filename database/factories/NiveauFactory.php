<?php

namespace Database\Factories;

use App\Models\Etablissement;
use App\Models\Niveau;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Niveau>
 */
class NiveauFactory extends Factory
{
    protected $model = Niveau::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'etablissement_id' => Etablissement::factory(),
            'libelle' => fake()->randomElement(['6ème', '5ème', '4ème', '3ème', '2nde', '1ère', 'Terminale']),
            'ordre' => fake()->numberBetween(1, 7),
            'frais_inscription' => fake()->randomFloat(2, 50000, 200000),
            'frais_ecolage_mensuel' => fake()->randomFloat(2, 30000, 150000),
        ];
    }
}
