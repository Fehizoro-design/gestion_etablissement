<?php

namespace Database\Factories;

use App\Enums\Sexe;
use App\Models\Eleve;
use App\Models\Etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eleve>
 */
class EleveFactory extends Factory
{
    protected $model = Eleve::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexe = fake()->randomElement(Sexe::cases());

        return [
            'etablissement_id' => Etablissement::factory(),
            'matricule' => 'ELV-'.str_pad((string) fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'nom' => fake()->lastName(),
            'prenom' => $sexe === Sexe::Masculin ? fake()->firstNameMale() : fake()->firstNameFemale(),
            'date_naissance' => fake()->dateTimeBetween('-18 years', '-5 years'),
            'lieu_naissance' => fake()->city(),
            'sexe' => $sexe,
            'nationalite' => 'Malagasy',
            'adresse' => fake()->address(),
            'nom_parent' => fake()->lastName(),
            'prenom_parent' => fake()->firstName(),
            'telephone_parent' => fake()->phoneNumber(),
            'email_parent' => fake()->safeEmail(),
            'profession_parent' => fake()->jobTitle(),
            'date_inscription' => fake()->dateTimeBetween('-2 years', 'now'),
            'is_active' => true,
        ];
    }
}
