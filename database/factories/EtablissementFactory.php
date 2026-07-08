<?php

namespace Database\Factories;

use App\Enums\TypeEtablissement;
use App\Models\Etablissement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Etablissement>
 */
class EtablissementFactory extends Factory
{
    protected $model = Etablissement::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nom' => fake()->company().' School',
            'type' => fake()->randomElement(TypeEtablissement::cases()),
            'adresse' => fake()->address(),
            'ville' => fake()->city(),
            'pays' => 'Madagascar',
            'telephone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'description' => fake()->paragraph(),
            'devise' => fake()->sentence(4),
            'code_etablissement' => 'ETB-'.strtoupper(fake()->bothify('########')),
            'is_active' => true,
        ];
    }
}
