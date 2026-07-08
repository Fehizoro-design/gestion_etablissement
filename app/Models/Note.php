<?php

namespace App\Models;

use App\Enums\TypeNote;
use Database\Factories\NoteFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'eleve_id', 'classe_id', 'matiere_id', 'periode_id',
    'type', 'note', 'note_sur', 'commentaire', 'date_evaluation',
])]
class Note extends Model
{
    /** @use HasFactory<NoteFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'type' => TypeNote::class,
            'note' => 'decimal:2',
            'note_sur' => 'decimal:2',
            'date_evaluation' => 'date',
        ];
    }

    /** @return BelongsTo<Eleve, $this> */
    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    /** @return BelongsTo<Classe, $this> */
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    /** @return BelongsTo<Matiere, $this> */
    public function matiere(): BelongsTo
    {
        return $this->belongsTo(Matiere::class);
    }

    /** @return BelongsTo<Periode, $this> */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    /**
     * Get the grade as a percentage.
     */
    public function pourcentage(): float
    {
        if ($this->note_sur == 0) {
            return 0;
        }

        return round(($this->note / $this->note_sur) * 100, 2);
    }
}
