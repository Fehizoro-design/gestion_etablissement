<?php

namespace App\Models;

use Database\Factories\NiveauFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['etablissement_id', 'libelle', 'ordre', 'frais_inscription', 'frais_ecolage_mensuel'])]
class Niveau extends Model
{
    /** @use HasFactory<NiveauFactory> */
    use HasFactory;

    protected $table = 'niveaux';

    protected function casts(): array
    {
        return [
            'frais_inscription' => 'decimal:2',
            'frais_ecolage_mensuel' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return HasMany<Classe, $this> */
    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }
}
