<?php

namespace App\Models;

use Database\Factories\PeriodeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['annee_scolaire_id', 'libelle', 'date_debut', 'date_fin', 'ordre'])]
class Periode extends Model
{
    /** @use HasFactory<PeriodeFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /** @return BelongsTo<AnneeScolaire, $this> */
    public function anneeScolaire(): BelongsTo
    {
        return $this->belongsTo(AnneeScolaire::class);
    }

    /** @return HasMany<Note, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
