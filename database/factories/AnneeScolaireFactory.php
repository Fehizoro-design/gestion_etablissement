<?php

namespace Database\Factories;

use App\Models\AnneeScolaire;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnneeScolaire>
 */
class AnneeScolaireFactory extends Factory
{
    protected $model = AnneeScolaire::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->numberBetween(2023, 2026);

        return [
            'etablissement_id' => Etablissement::factory(),
            'libelle' => $year.'-'.($year + 1),
            'date_debut' => $year.'-09-01',
            'date_fin' => ($year + 1).'-07-31',
            'is_active' => false,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['is_active' => true]);
    }
}
