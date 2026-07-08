<?php

namespace Database\Factories;

use App\Enums\Sexe;
use App\Models\Enseignant;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enseignant>
 */
class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexe = fake()->randomElement(Sexe::cases());

        return [
            'etablissement_id' => Etablissement::factory(),
            'nom' => fake()->lastName(),
            'prenom' => $sexe === Sexe::Masculin ? fake()->firstNameMale() : fake()->firstNameFemale(),
            'email' => fake()->unique()->safeEmail(),
            'telephone' => fake()->phoneNumber(),
            'adresse' => fake()->address(),
            'date_naissance' => fake()->dateTimeBetween('-60 years', '-25 years'),
            'lieu_naissance' => fake()->city(),
            'sexe' => $sexe,
            'nationalite' => 'Malagasy',
            'diplome' => fake()->randomElement(['Licence', 'Master', 'Doctorat', 'CAPEN', 'Ingénieur']),
            'specialite' => fake()->randomElement(['Mathématiques', 'Français', 'Physique', 'SVT', 'Anglais', 'Histoire-Géo']),
            'date_embauche' => fake()->dateTimeBetween('-10 years', 'now'),
            'salaire_base' => fake()->randomFloat(2, 300000, 1500000),
            'is_active' => true,
        ];
    }
}
