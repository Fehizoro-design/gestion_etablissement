<?php

namespace Database\Factories;

use App\Models\Etablissement;
use App\Models\Matiere;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matiere>
 */
class MatiereFactory extends Factory
{
    protected $model = Matiere::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $matieres = [
            ['nom' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 4],
            ['nom' => 'Français', 'code' => 'FR', 'coefficient' => 4],
            ['nom' => 'Anglais', 'code' => 'ANG', 'coefficient' => 2],
            ['nom' => 'Physique-Chimie', 'code' => 'PC', 'coefficient' => 3],
            ['nom' => 'SVT', 'code' => 'SVT', 'coefficient' => 2],
            ['nom' => 'Histoire-Géo', 'code' => 'HG', 'coefficient' => 2],
            ['nom' => 'Malagasy', 'code' => 'MLG', 'coefficient' => 2],
            ['nom' => 'EPS', 'code' => 'EPS', 'coefficient' => 1],
        ];
        $matiere = fake()->randomElement($matieres);

        return [
            'etablissement_id' => Etablissement::factory(),
            'nom' => $matiere['nom'],
            'code' => $matiere['code'],
            'coefficient' => $matiere['coefficient'],
        ];
    }
}
