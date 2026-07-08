<?php

namespace App\Models;

use App\Enums\Sexe;
use Database\Factories\EnseignantFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'etablissement_id', 'nom', 'prenom', 'email', 'telephone', 'adresse',
    'date_naissance', 'lieu_naissance', 'sexe', 'nationalite', 'diplome',
    'specialite', 'date_embauche', 'salaire_base', 'photo', 'numero_cin', 'is_active',
])]
class Enseignant extends Model
{
    /** @use HasFactory<EnseignantFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'sexe' => Sexe::class,
            'date_naissance' => 'date',
            'date_embauche' => 'date',
            'salaire_base' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return HasMany<Salaire, $this> */
    public function salaires(): HasMany
    {
        return $this->hasMany(Salaire::class);
    }

    /** @return BelongsToMany<Classe, $this> */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'classe_matiere_enseignant')
            ->withPivot('matiere_id', 'annee_scolaire_id')
            ->withTimestamps();
    }

    /**
     * Get the teacher's full name.
     */
    public function nomComplet(): string
    {
        return $this->prenom.' '.$this->nom;
    }
}
