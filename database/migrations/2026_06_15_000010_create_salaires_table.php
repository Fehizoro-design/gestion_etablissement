<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enseignant_id')->constrained()->cascadeOnDelete();
            $table->decimal('montant', 12, 2);
            $table->integer('mois');
            $table->integer('annee');
            $table->date('date_paiement')->nullable();
            $table->string('statut')->default('en_attente');
            $table->string('mode_paiement')->nullable();
            $table->string('reference')->nullable();
            $table->text('remarques')->nullable();
            $table->timestamps();

            $table->unique(['enseignant_id', 'mois', 'annee']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaires');
    }
};
