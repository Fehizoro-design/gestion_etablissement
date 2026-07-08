<?php

namespace Database\Factories;

use App\Enums\TypeNote;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Matiere;
use App\Models\Note;
use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    protected $model = Note::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'eleve_id' => Eleve::factory(),
            'classe_id' => Classe::factory(),
            'matiere_id' => Matiere::factory(),
            'periode_id' => Periode::factory(),
            'type' => fake()->randomElement(TypeNote::cases()),
            'note' => fake()->randomFloat(2, 0, 20),
            'note_sur' => 20,
            'date_evaluation' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
