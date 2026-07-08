<?php

namespace App\Models;

use App\Enums\Sexe;
use Database\Factories\EleveFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'etablissement_id', 'matricule', 'nom', 'prenom', 'date_naissance',
    'lieu_naissance', 'sexe', 'nationalite', 'adresse', 'photo',
    'nom_parent', 'prenom_parent', 'telephone_parent', 'email_parent',
    'profession_parent', 'groupe_sanguin', 'allergies', 'remarques',
    'date_inscription', 'is_active',
])]
class Eleve extends Model
{
    /** @use HasFactory<EleveFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'sexe' => Sexe::class,
            'date_naissance' => 'date',
            'date_inscription' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return BelongsToMany<Classe, $this> */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'classe_eleve')
            ->withPivot('annee_scolaire_id', 'date_inscription', 'statut')
            ->withTimestamps();
    }

    /** @return HasMany<Note, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /** @return HasMany<PaiementEcolage, $this> */
    public function paiementEcolages(): HasMany
    {
        return $this->hasMany(PaiementEcolage::class);
    }

    /**
     * Get the student's full name.
     */
    public function nomComplet(): string
    {
        return $this->prenom.' '.$this->nom;
    }

    protected static function booted(): void
    {
        static::creating(function (Eleve $eleve) {
            if (empty($eleve->matricule)) {
                $count = Eleve::where('etablissement_id', $eleve->etablissement_id)->count() + 1;
                $eleve->matricule = 'ELV-'.str_pad((string) $count, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
