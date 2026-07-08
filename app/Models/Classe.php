<?php

namespace App\Models;

use Database\Factories\ClasseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['etablissement_id', 'niveau_id', 'annee_scolaire_id', 'nom', 'capacite_max'])]
class Classe extends Model
{
    /** @use HasFactory<ClasseFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'capacite_max' => 'integer',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return BelongsTo<Niveau, $this> */
    public function niveau(): BelongsTo
    {
        return $this->belongsTo(Niveau::class);
    }

    /** @return BelongsTo<AnneeScolaire, $this> */
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    /** @return BelongsToMany<Eleve, $this> */
    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'classe_eleve')
            ->withPivot('annee_scolaire_id', 'date_inscription', 'statut')
            ->withTimestamps();
    }

    /** @return HasMany<Note, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the number of enrolled students.
     */
    public function effectif(): int
    {
        return $this->eleves()->count();
    }
}
