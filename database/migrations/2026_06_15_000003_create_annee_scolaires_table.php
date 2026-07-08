<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annee_scolaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etablissement_id')->constrained()->cascadeOnDelete();
            $table->string('libelle');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        Schema::create('periodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('annee_scolaire_id')->constrained()->cascadeOnDelete();
            $table->string('libelle');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->integer('ordre')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('periodes');
        Schema::dropIfExists('annee_scolaires');
    }
};
