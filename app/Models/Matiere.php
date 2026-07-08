<?php

namespace App\Models;

use Database\Factories\MatiereFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['etablissement_id', 'nom', 'code', 'coefficient'])]
class Matiere extends Model
{
    /** @use HasFactory<MatiereFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'coefficient' => 'decimal:2',
        ];
    }

    /** @return BelongsTo<Etablissement, $this> */
    public function etablissement(): BelongsTo
    {
        return $this->belongsTo(Etablissement::class);
    }

    /** @return HasMany<Note, $this> */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
