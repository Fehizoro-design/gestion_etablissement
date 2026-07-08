<?php

namespace App\Models;

use App\Enums\TypeEtablissement;
use Database\Factories\EtablissementFactory;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id', 'nom', 'type', 'adresse', 'ville', 'pays', 'telephone',
    'email', 'site_web', 'logo', 'description', 'devise',
    'code_etablissement', 'is_active',
])]
class Etablissement extends Model implements HasCurrentTenantLabel, HasName
{
    /** @use HasFactory<EtablissementFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => TypeEtablissement::class,
            'is_active' => 'boolean',
        ];
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Établissement actif';
    }

    public function getFilamentName(): string
    {
        return $this->nom;
    }

    /** @return BelongsTo<User, $this> */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return BelongsToMany<User, $this> */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'etablissement_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    /** @return HasMany<AnneeScolaire, $this> */
    public function anneeScolaires(): HasMany
    {
        return $this->hasMany(AnneeScolaire::class);
    }

    /** @return HasMany<Niveau, $this> */
    public function niveaux(): HasMany
    {
        return $this->hasMany(Niveau::class);
    }

    /** @return HasMany<Classe, $this> */
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    /** @return HasMany<Matiere, $this> */
    public function matieres(): HasMany
    {
        return $this->hasMany(Matiere::class);
    }

    /** @return HasMany<Enseignant, $this> */
    public function enseignants(): HasMany
    {
        return $this->hasMany(Enseignant::class);
    }

    /** @return HasMany<Eleve, $this> */
    public function eleves(): HasMany
    {
        return $this->hasMany(Eleve::class);
    }

    protected static function booted(): void
    {
        static::creating(function (Etablissement $etablissement) {
            if (empty($etablissement->code_etablissement)) {
                $etablissement->code_etablissement = 'ETB-'.strtoupper(substr(md5(uniqid()), 0, 8));
            }
        });
    }
}
