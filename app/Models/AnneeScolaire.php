<?php

namespace App\Models;

use Database\Factories\AnneeScolaireFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['etablissement_id', 'libelle', 'date_debut', 'date_fin', 'is_active'])]
class AnneeScolaire extends Model
{
    /** @use HasFactory<AnneeScolaireFactory> */
    use HasFactory;

    protected $table = 'annee_scolaires';

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return HasMany<Periode, $this> */
    public function periodes(): HasMany
    {
        return $this->hasMany(Periode::class)->orderBy('ordre');
    }

    /** @return HasMany<Classe, $this> */
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }
}
