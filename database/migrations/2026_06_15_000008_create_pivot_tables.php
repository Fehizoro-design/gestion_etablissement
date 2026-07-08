<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe_eleve', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('eleve_id')->constrained()->cascadeOnDelete();
            $table->foreignId('annee_scolaire_id')->constrained()->cascadeOnDelete();
            $table->date('date_inscription');
            $table->string('statut')->default('inscrit');
            $table->timestamps();

            $table->unique(['classe_id', 'eleve_id', 'annee_scolaire_id']);
        });

        Schema::create('classe_matiere_enseignant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->cascadeOnDelete();
            $table->foreignId('matiere_id')->constrained()->cascadeOnDelete();
            $table->foreignId('enseignant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('annee_scolaire_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(
                ['classe_id', 'matiere_id', 'annee_scolaire_id'],
                'classe_matiere_annee_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_matiere_enseignant');
        Schema::dropIfExists('classe_eleve');
    }
};
